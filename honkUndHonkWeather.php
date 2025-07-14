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


class ShortCode
{
    public const string SAVE_PATH = '/var/cache/HonkUndHonkWeather/';
    readonly float  $lon;
    readonly float  $lat;
    readonly string $type;
    readonly string $value;
    #
    
    public function __construct(array $params)
    {
        $arrError = [];
        
        if (! isset($params['lon'])) {
            $arrError[] = 'Missing parameter lon';
        }
        
        if (! isset($params['lat'])) {
            $arrError[] = 'Missing parameter lat';
        }
        
        if (! isset($params['type'])) {
            $arrError[] = 'Missing parameter type';
        }
        
        if (0 === count($arrError)) {
            // All expected parameter present, check the parameters
            $arrError += $this->checkParameters($params);
        }
        
        if (0 !== count($arrError)) {
            
            $value = '<ul class="error">';
            foreach ($arrError as $msg) {
                $value .= "<li>{$msg}</li>";
            }
            $value .= '</ul>';
            
            $this->value = $value;
            
            return;
        }
        
        $this->lon  = floatval($params['lon']);
        $this->lat  = floatval($params['lat']);
        $this->type = $params['type'];
        
        $this->value = $this->getValue();
    }
    
    
    protected function checkParameters(array &$params)
    {
        $arrAllowedTypes = ['json', 'htmlTable', 'htmlDiv'];
        $arrErr          = [];
        
        if (false === in_array($params['type'], $arrAllowedTypes)) {
            $arrErr['e3'] = 'Parameter type has invalid value';
        }
        
        return $arrErr;
    }
    
    
    protected function getValue() 
    {
        $savePath = $this->buildSavePath();
        
        if (true === is_dir($savePath)) {
            $content = file_get_contents($savePath . $this->type);
            if (false === $content) {
                $content = "<ul class=\"error\"><li>Can't read data: {$savePath}{$this->type}</li></ul>";
            }
            
        } else {
            // Create data directory
            if (false === mkdir($savePath)) {
                $content = "<ul class=\"error\"><li>Can't create data directory: {$savePath}</li></ul>";
            } else {
                $content = "Data directory created, come back in six houres.";
            }
        }
        
        return "<div class=\"honkWeatherOuter\">{$content}</div>";
    }
    
    
    protected function buildSavePath(): string
    {
        return ShortCode::SAVE_PATH . $this->lon . '_' . $this->lat . '/';   
    }
}


function honkUndHonkWeatherShortcodeHandler(array $params)
{
    try {
        $shortCode = new ShortCode($params);
        return $shortCode->value;
        
    } catch (Exception $e) {
        return "
            <div class=\"honkUndHonkWeatherOuter\">
                <div class=\"error\">{$e->getMessage()}</div>
            </div>";
    }
}
