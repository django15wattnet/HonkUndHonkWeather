<?php

readonly class ForecastDaySlider
{
    public array $arrDays;
    
    /**
     * 
     * @param ForecastRenderer[] $data
     */
    public function __construct(array $forecastRenderers) 
    {
        $arrDays = [];
        
        foreach ($forecastRenderers as $fr) {
            $day = $fr->dt->format('j. D');
            $time = $fr->dt->format('H:i');
            
            if (false === isset($arrDays[$day])) {
                $arrDays[$day] = $fr->idx;
                
                continue;
            }
            
            if ('12:00' === $time) {
                $arrDays[$day] = $fr->idx;
            }
        }
        
        $this->arrDays = $arrDays;
    }
    
    
    public function __toString(): string
    {
        ob_start();
        include __dir__ . '/resources/templates/forecastDaySlider.php';
        return ob_get_clean();
    }
}
