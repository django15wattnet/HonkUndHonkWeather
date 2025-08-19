<?php
/**
 * Plugin Name:       HonkUndHonkWeather
 * Plugin URI:        https://github.com/django15wattnet/HonkUndHonkWeather
 * Description:       OpenMeteo weather forecast as a Wordpress plugin
 * Version:           0.0.1
 * Author:            https://github.com/django15wattnet
 * Author URI:        https://github.com/django15wattnet
 * License:           unlicense
 * License URI:       https://unlicense.org
 * Text Domain:       honkandhonkweather
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once 'Renderer.php';
require_once 'ForecastRenderer.php';
require_once 'ForecastData.php';
require_once 'ShortCode.php';
require_once 'Units.php';

use ShortCode;


add_shortcode('honkUndHonkWeather', 'honkUndHonkWeatherShortcodeHandler');


function honkUndHonkWeatherShortcodeHandler(array $params)
{
    try {
        return (new ShortCode($params))->value;        
    } catch (Exception $e) {
        return "
            <div class=\"honkUndHonkWeatherOuter\">
                <div class=\"error\">{$e->getMessage()}</div>
            </div>";
    }
}
