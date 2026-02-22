<?php
require_once __DIR__ . '/Importer.php';
require_once __DIR__ . '/Point.php';
require_once __DIR__ . '/DirectoryToPointList.php';

use HonkUndHonkWeather\Importer\Importer;
use HonkUndHonkWeather\Importer\DirectoryToPointList;

foreach (new DirectoryToPointList() as $point) {
    try {
        (new Importer($point))->writeForecastData();
    } catch (Exception $e) {
        printf(
            'Error importing forecast for point %f, %f: %s',
            $point->getLon(),
            $point->getLat(),
            $e->getMessage()
        );
    }
   
}
