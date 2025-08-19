<?php

class Renderer
{
    readonly public string $value;
    protected Units $units;
    protected array $arrForecastHtml = [];
    
    
    
    public function __construct($data)
    {
        if (false === property_exists($data, 'units')) {
            throw new Exception('Missing property units');
        }
        
        if (false === property_exists($data, 'forecasts')) {
            throw new Exception('Missing property units');
        }
        
        $this->units = new Units($data->units);
        
        $out = '';
        
        foreach ($data->forecasts as $fc) {
            $forecastData = new ForecastData($fc);
            $out .= print_r($forecastData, true) . PHP_EOL;
        }
        
        
        $this->value = '<pre>' . $out . '</pre>';
    }
}
