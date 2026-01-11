<?php
// l,      j.  F         Y     H:i
// Monday, 22. September 2025 16:00 
function honkUndHonkWeatherPrDateLong(DateTime $dt): void
{
    $strDt = __($dt->format('l'));
    $strDt .= ', ';
    $strDt .= $dt->format('j');
    $strDt .= '. ';
    $strDt .= __($dt->format(('F')));
    $strDt .= $dt->format(' Y H:i');
    
    print($strDt);
}

/**
 * Englischer Tag zu deutsch
 * 11. Sun => 11. So.
 * 
 * @param string $day
 */
function honkUndHonkWeatherPrDayShort(string $day): void
{
    $arrParts = explode(' ', $day);
    
    if (2 != count($arrParts)) {
        print($day);
    }
    
    print("{$arrParts[0]} ");
    _e($arrParts[1], 'honkUndHonkWeather');
}
