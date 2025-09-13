<?php

class ForecastRenderer
{
    protected DateTime $dt;
    protected WmoCode $wmoCode;
    
    
    public function __construct(protected ForecastData $forecastData, protected int $idx)
    {
        $this->dt = (new DateTime($this->forecastData->time))->setTimezone(new DateTimeZone('Europe/Berlin'));
        $this->wmoCode = new WmoCode();
        // print('<pre>'); print_r($this->forecastData); die();
    }
    
    
    public function __toString()
    {
        ob_start();
        include __dir__ . '/resources/templates/forecastDataTable.php';
        return ob_get_clean();
    }
}

