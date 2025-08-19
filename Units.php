<?php

/*
    stdClass Object
    (
        [time] => iso8601
        [temperature_2m] => °C
        [relative_humidity_2m] => %
        [cloud_cover] => %
        [wind_speed_10m] => km/h
        [rain] => mm
        [weather_code] => wmo code
        [wind_direction_10m] => °
        [surface_pressure] => hPa
        [precipitation_probability] => %
    )
 */
class Units
{   
    protected array $arrUnits = [
        'time'                      => '',
        'temperature_2m'            => '',
        'relative_humidity_2m'      => '',
        'cloud_cover'               => '',
        'wind_speed_10m'            => '',
        'rain'                      => '',
        'weather_code'              => '',
        'wind_direction_10m'        => '',
        'surface_pressure'          => '',
        'precipitation_probability' => ''
    ];
    
    public function __construct(stdClass $units)
    {
        foreach (array_keys($this->arrUnits) as $key) {
            
            if (false === property_exists($units, $key)) {
                throw new Exception("Missing unit for {$key}.");
            }
            
            $this->arrUnits[$key] = $units->$key;
        }
    }
    
    
    public function __get(string $prop): string
    {
        if (false === isset($this->arrUnits[$prop])) {
            throw new Exception("No unit for value {$prop}.");
        }
        
        return $this->arrUnits[$prop];
    }
}
