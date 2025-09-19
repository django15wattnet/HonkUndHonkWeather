<?php
/**
 * Plugin Name:       HonkUndHonkWeather
 * Plugin URI:        https://github.com/django15wattnet/HonkUndHonkWeather
 * Description:       OpenMeteo weather forecast as a Wordpress plugin
 * Version:           0.0.1
 * Author:            https://github.com/django15wattnet
 * Author URI:        https://honkundhonk.de
 * License:           GNU General Public License 3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       honkundhonkweather
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once 'Renderer.php';
require_once 'ForecastRenderer.php';
require_once 'ForecastData.php';
require_once 'ForecastDaySlider.php';
require_once 'ShortCode.php';
require_once 'Units.php';
require_once 'WmoCode.php';


add_shortcode('honkUndHonkWeather', 'honkUndHonkWeatherShortcodeHandler');

function honkUndHonkWeatherShortcodeHandler(array $params)
{
    setlocale(LC_ALL, 'de_DE.UTF-8');
    try {
        return (new ShortCode($params))->value;        
    } catch (Exception $e) {
        return "
            <div class=\"honkUndHonkWeatherOuter\">
                <div class=\"error\">{$e->getMessage()}</div>
            </div>";
    }
}


// Add wp cron to read the weather forecasts houly
add_action(
    'HonkUndHonkWeatherReadForecastsCron',
    'honkUndHonkWeatherReadForecastsCronExec'
);

function activate()
{
    error_log("honkUndHonkWeatherReadForecasts activate");
    wp_schedule_event(time(), 'hourly', 'HonkUndHonkWeatherReadForecastsCron');
}

function deactivate()
{
    error_log("honkUndHonkWeatherReadForecasts deactivate");
    wp_clear_scheduled_hook('HonkUndHonkWeatherReadForecastsCron');
}

function honkUndHonkWeatherReadForecastsCronExec(): void
{
    $pythonInterpreter = shell_exec("which python3");
    if (true === in_array($pythonInterpreter, [false, null], true)) {
        error_log("honkUndHonkWeatherReadForecastsCronExec(): Can't find python3 interpreter");
        return;
    }
    
    $pythonInterpreter = trim($pythonInterpreter, "\n\r ");
    
    $pathToScript = dirname(__FILE__) . '/Importer/importer.py';
    
    error_log("{$pythonInterpreter} {$pathToScript}");
    $res = shell_exec("{$pythonInterpreter} {$pathToScript}");
    if (true === in_array($res, [false, null], true)) {
        error_log("honkUndHonkWeatherReadForecastsCronExec(): Can't run importer");
        return;
    }
    
    error_log("honkUndHonkWeatherReadForecastsCronExec(): Success 🌞");
    
    return;
}
