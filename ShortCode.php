<?php

class ShortCode
{
    public const string SAVE_PATH = '/var/cache/HonkUndHonkWeather/';
    readonly float  $lon;
    readonly float  $lat;
    readonly string $type;
    readonly string $value;
    
    
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
        
        try {
            $this->value = $this->getValue();
        } catch (Exception $e) {
            $file = $e->getFile();
            $line = $e->getLine();
            $msg  = $e->getMessage();
            $this->value = "<div class=\"honkWeatherOuter\"><div class=\"error\">{$file}:{$line} - {$msg}</div></div>";
        }
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
        $nameDataFile = $this->buildSavePath();
        
        if (! file_exists($nameDataFile)) {
            throw new Exception("Forecast data not read yet, please come back in about six houres.");
        }
        
        if (false === ($dataJson = file_get_contents($nameDataFile))) {
            throw new Exception("Can't read forecast data: {$nameDataFile}.");
        }
        
        try {
            $dataForecast = json_decode($dataJson, false, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            throw new Exception("Can't parse forecast data: {$nameDataFile} -> {$e->getMessage()}.");
        }
        
        $content = (new Renderer($dataForecast))->value;
        return "<div class=\"honkWeatherOuter\">{$content}</div>";
    }
    
    
    protected function buildSavePath(): string
    {
        return ShortCode::SAVE_PATH . $this->lon . '_' . $this->lat;
    }
}

