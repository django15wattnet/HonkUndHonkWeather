<?php
require_once __DIR__ . '/Importer.php';
require_once __DIR__ . '/Point.php';
require_once __DIR__ . '/DirectoryToPointList.php';

use Importer\Importer;
use Importer\DirectoryToPointList;

$dtpl = new DirectoryToPointList();
foreach ($dtpl as $point) {
    $imp = new Importer($point);
    print_r($imp);
}

/*
$imp = new Importer(
    new Point(7.625917, 51.962645)
);
*/
