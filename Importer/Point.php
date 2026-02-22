<?php
namespace HonkUndHonkWeather\Importer;

/**
 * A point, a geolocation to import the open meteo forecasts
 * 
 * @author ts
 */
class Point
{
   protected float $lon;
   protected float $lat;
   
   public function __construct(float $lon, float $lat)
   {
       $this->lon = $lon;
       $this->lat = $lat;
   }
   
   
   public function getLon(): float
   {
       return $this->lon;
   }
   
   
   public function getLat(): float
   {
       return $this->lat;
   }
   
   
   public function __toString(): string
   {
       return sprintf(
           '%s_%s', 
           rtrim(sprintf('%f', $this->lat), '0'), 
           rtrim(sprintf('%f', $this->lon), '0')
       );
   }
   
}
