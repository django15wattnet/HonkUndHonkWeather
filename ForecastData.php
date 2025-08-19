<?php

/*
    stdClass Object
    (
        [lat] => 51.97
        [lon] => 7.6559997
        [time] => 2025-08-19T00:00:00+02:00
        [tz] => GMT
        [temperature_2m] => 16.3
        [relative_humidity_2m] => 78
        [cloud_cover] => 0
        [rain] => 0
        [weather_code] => 0
        [wind_direction_10m] => 41
        [surface_pressure] => 1010
        [precipitation_probability] => 0
    )
 */
class ForecastData
{
    protected array $arrData = [
        'time'                      => null,
        'tz'                        => null,
        'temperature_2m'            => null,
        'relative_humidity_2m'      => null,
        'cloud_cover'               => null,
        'rain'                      => null,
        'weather_code'              => null,
        'wind_direction_10m'        => null,
        'surface_pressure'          => null,
        'precipitation_probability' => null
    ];
    
    
    public function __construct(stdClass $data)
    {
        foreach (array_keys($this->arrData) as $key) {
            if (false === property_exists($data, $key)) {
                throw new Exception("Missing property {$key} in forecast data.");
            }
            
            $this->arrData[$key] = $data->$key;
        }
    }
    
    
    public function __get($prop)
    {
        if (false === isset($this->arrData[$prop])) {
            throw new Exception("No data for property {$prop}.");
        }
        
        return $this->arrData[$prop];
    }
}
