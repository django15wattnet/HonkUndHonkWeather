<?php

class ForecastRenderer
{
    readonly public DateTime $dt;
    protected WmoCode $wmoCode;
    
    
    public function __construct(
        protected ForecastData $forecastData, 
        readonly public int $idx)
    {
        $this->dt = (new DateTime($this->forecastData->time))->setTimezone(new DateTimeZone('Europe/Berlin'));
        $this->wmoCode = new WmoCode();
    }
    
    
    public function __toString()
    {
        ob_start();
        include __dir__ . '/resources/templates/forecastDataTable.php';
        return ob_get_clean();
    }
}

