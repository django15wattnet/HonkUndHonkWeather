<?php

class Renderer
{
    readonly public string $value;
    readonly protected Units $units;
    readonly protected array $forecastRenderers;
    readonly protected ForecastDaySlider $forecastDaySlider;
    
    
    public function __construct(readonly protected 
        ShortCode $shortCode, 
        stdClass $data
    )
    {
        if (false === property_exists($data, 'units')) {
            throw new Exception('Missing property units');
        }
        
        if (false === property_exists($data, 'forecasts')) {
            throw new Exception('Missing property units');
        }
        
        $units = new Units($data->units);
        
        // Vorhersagen neuer als jetzt plus 1 Stunden
        $dtNowPlusOne = new DateTime('now');
        $dtNowPlusOne->modify('+1 Hour');
        
        $arrNewForecasts = array_filter(
            $data->forecasts,
            function(stdClass $data) use($dtNowPlusOne): bool
            {
                return (new DateTime($data->time)) > $dtNowPlusOne;
            }
        );
        
        $idx = 0;
        $this->forecastRenderers = array_map(
            function(stdClass $data) use($units, &$idx) 
            {
                return new ForecastRenderer(new ForecastData($data, $units), $idx++);
            },
            $arrNewForecasts
        );
        
        $this->forecastDaySlider = new ForecastDaySlider($this->forecastRenderers);
        
        ob_start();
        include __dir__ . '/resources/templates/forecast.php';
        $this->value = ob_get_clean();
    }
}
