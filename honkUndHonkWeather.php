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

add_shortcode('honkUndHonkWeather', 'honkUndHonkWeatherShortcodeHandler');
    
function honkUndHonkWeatherShortcodeHandler(array $params)
{
    return '<pre>' . print_r($params, true) . '</pre>';
}
