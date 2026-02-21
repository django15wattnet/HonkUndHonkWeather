<?php
namespace Importer;

use Exception;
use Iterator;

class DirectoryToPointList implements \Iterator
{
    /**
     * List of points / locations to import the forecasts for
     * @var Point[]
     */
    protected  $points = [];
    
    /**
     * Directory where the forecast data is stored
     * Example: 51.962645_7.625917
     * @var string
     */
    protected string $dirCache;
        
    /**
     * Regular expression to match the point files in the cache directory
     * @var string
     */
    protected const regExPointFile = '/^[0-9]{1,3}\.[0-9]{1,}_[0-9]{1,3}\.[0-9]{1,}$/';
    
    private int $position = 0;
    
    
    public function __construct() 
    {
        $this->position = 0;
        $this->dirCache = realpath(__DIR__ . '/../resources/data');
        
        if (false === is_dir($this->dirCache)) {
            throw new Exception("Directory for cache data does not exist: {$this->dirCache}");
        }
        
        $dirHandle = opendir($this->dirCache);
        if (false === $dirHandle) {
            throw new Exception("Could not open directory for cache data: {$this->dirCache}");
        }
        
        while (true) {
            
            $dirEntry = readdir($dirHandle);
            if (false === $dirEntry) {
                break;
            }
            
            if (1 !== preg_match(self::regExPointFile, $dirEntry)) {
                // No point file, skip
                continue;
            }
            
            list ($lon, $lat) = explode('_', $dirEntry);
            
            $this->points[] = new Point(floatval($lat), floatval($lon));            
        }
        
        closedir($dirHandle);
    }
    

    // Iterator methods
    public function current()
    {
        return $this->points[$this->position] ?? null;
    }
    
    
    public function key()
    {
        return $this->position;
    }
    
    
    public function next(): void
    {
        ++$this->position;
    }
    
    
    public function rewind(): void
    {
        $this->position = 0;
    }
    
    
    public function valid(): bool
    {
        return isset($this->points[$this->position]);
    }
}