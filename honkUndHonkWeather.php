<?php
use HonkUndHonkWeather\Importer\Importer;

/**
 * Plugin Name:       HonkUndHonkWeather
 * Plugin URI:        https://github.com/django15wattnet/HonkUndHonkWeather
 * Description:       OpenMeteo weather forecast as a Wordpress plugin
 * Version:           0.0.1
 * Author:            https://github.com/django15wattnet
 * Author URI:        https://honkundhonk.de
 * License:           GNU General Public License 3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       honkUndHonkWeather
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once 'templateFunctions.php';
require_once 'Renderer.php';
require_once 'ForecastRenderer.php';
require_once 'ForecastData.php';
require_once 'ForecastDaySlider.php';
require_once 'ShortCode.php';
require_once 'Units.php';
require_once 'WmoCode.php';
require_once 'Importer/Point.php';
require_once 'Importer/Importer.php';
require_once 'Importer/DirectoryToPointList.php';

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


function honkUndHonkWeatherReadForecastsCronExec(): void
{
    foreach (new Importer/DirectoryToPointList() as $point) {
        try {
            (new Importer($point))->writeForecastData();
        } catch (Exception $e) {
            error_log(
                sprintf(
                    'Error importing forecast for point %f, %f: %s',
                    $point->getLon(),
                    $point->getLat(),
                    $e->getMessage()
                )
            );
        }
    }                                                                

    error_log("honkUndHonkWeatherReadForecastsCronExec(): Success 🌞");
    
    return;
}

function honkUndHonkWeatherReadForecastsCron() {
    honkUndHonkWeatherReadForecastsCronExec();
}


// Add wp cron to read the weather forecasts hourly
add_action(
    'init',
    'honkUndHonkWeatherCreateCron'
);

function honkUndHonkWeatherCreateCron()
{
    if (! wp_next_scheduled('honkUndHonkWeatherReadForecastsCron')) {
        error_log("honkUndHonkWeatherCreateCron(): Schedule cron");
        wp_schedule_event(time(), '5min', 'honkUndHonkWeatherReadForecastsCron');
    }
}



// Add the plugins translations
add_action(
    'plugins_loaded',
    function() 
    {
        load_plugin_textdomain(
            'honkUndHonkWeather',
            false,
            basename(dirname( __FILE__ )) . '/resources/lang'
        );
    }
);


function activate()
{
    die('wTf');
    error_log("honkUndHonkWeatherReadForecasts activate");
    wp_schedule_event(time(), '5min', 'honkUndHonkWeatherReadForecastsCron');
}

function deactivate()
{
    error_log("honkUndHonkWeatherReadForecasts deactivate");
    wp_clear_scheduled_hook('honkUndHonkWeatherReadForecastsCron');
}