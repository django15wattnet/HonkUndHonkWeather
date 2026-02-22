<?php
namespace HonkUndHonkWeather\Importer;

use DateTimeZone;
use DateTime;
use stdClass;
use Exception;

/**
 * Class to import the open meteo forecast for a location (Point)
 * 
 * @author ts
 */
class Importer
{
    /**
     * URI template to import the data from open meteo
     * @const string
     */
    protected const uriTemplate = 'https://api.open-meteo.com/v1/forecast?latitude=%f&longitude=%f&hourly=temperature_2m,relative_humidity_2m,cloud_cover,wind_speed_10m,rain,weather_code,wind_direction_10m,surface_pressure,precipitation_probability&models=best_match&timezone=auto';
    
    /**
     * Where to store the forecast data
     * @var string
     */
    protected string $dirCache;
    
    /**
     * The point / location to import the forecasts from open meteo
     * @var Point
     */
    protected Point $point;
    
    /**
     * The forecast data for the point / location
     * @var stdClass
     */
    protected stdClass $forecastData;
    
    
    
    public function __construct(Point $point) 
    {
        $this->dirCache = realpath(__DIR__ . '/../resources/data');
        $this->point    = $point;
        $openMeteoData  = $this->readForecastData();
        $objUnits       = (object)array_combine(array_keys(
            $openMeteoData['hourly']), 
            array_values($openMeteoData['hourly_units'])
        );
        
        $tz = new DateTimeZone($openMeteoData['timezone']);
        $arrWeatherForecasts = [];
        
        foreach ($openMeteoData['hourly']['time'] as $idx => $time) {
            
            $arrWeatherForecasts[] = (object)[
                'lat'                       => $this->point->getLat(),
                'lon'                       => $this->point->getLon(),
                'time'                      => (new DateTime($time, $tz))->format('c'),
                'tz'                        => $openMeteoData['timezone'],
                'temperature_2m'            => $openMeteoData['hourly']['temperature_2m'][$idx],
                'relative_humidity_2m'      => $openMeteoData['hourly']['relative_humidity_2m'][$idx],
                'cloud_cover'               => $openMeteoData['hourly']['cloud_cover'][$idx],
                'wind_speed_10m'            => $openMeteoData['hourly']['wind_speed_10m'][$idx],
                'rain'                      => $openMeteoData['hourly']['rain'][$idx],
                'weather_code'              => $openMeteoData['hourly']['weather_code'][$idx],
                'wind_direction_10m'        => $openMeteoData['hourly']['wind_direction_10m'][$idx],
                'surface_pressure'          => $openMeteoData['hourly']['surface_pressure'][$idx],
                'precipitation_probability' => $openMeteoData['hourly']['precipitation_probability'][$idx]
            ];
        }
        
        $this->forecastData = (object)[
            'units'     => $objUnits,
            'forecasts' => $arrWeatherForecasts
        ];
    }
    
    
    public function writeForecastData(): void
    {
        $nameDataFile = $this->dirCache . '/' . (string)$this->point;
        
        $res = file_put_contents(
            $nameDataFile, 
            json_encode($this->forecastData, JSON_PRETTY_PRINT)
        );
        
        if (false === $res) {
            throw new Exception("Could not write forecast data to file: {$nameDataFile}");
        }
    }
    
    
    protected function readForecastData(): array
    {
        // @todo: Handle exceptions
        $json = file_get_contents(
            sprintf(
                self::uriTemplate, 
                $this->point->getLat(), 
                $this->point->getLon()
            )
        );
        
        return  json_decode($json, true);
    }
}
