<?php

class Renderer
{
    readonly public string $value;
    protected Units $units;
    protected array $forecastRenderers = [];
    
    
    public function __construct($data)
    {
        if (false === property_exists($data, 'units')) {
            throw new Exception('Missing property units');
        }
        
        if (false === property_exists($data, 'forecasts')) {
            throw new Exception('Missing property units');
        }
        
        $units = new Units($data->units);
        
        // Vorhersagen neuer als jetzt plus 2 Stunden
        $dtNowPlusTwo = new DateTime('now');
        $dtNowPlusTwo->modify('+2 Hour');
        
        $arrNewForecasts = array_filter(
            $data->forecasts,
            function(stdClass $data) use($dtNowPlusTwo): bool
            {
                return (new DateTime($data->time)) > $dtNowPlusTwo;
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
        
        ob_start();
        include __dir__ . '/resources/templates/forecast.php';
        $this->value = ob_get_clean();
    }
}
