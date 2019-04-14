<?php

/*
$datetime = date_create("5678-10-12 15:45:20");
$date = date_format($datetime, 'Y-m-d');
$ddd = date_sub($datetime, date_interval_create_from_date_string('10 days'));

$toMysql = date_format($ddd,'Y-m-d H:i:s');

$timestamp = mktime(13,30,0,5,18,2035);
$date = date("Y-m-d h:i:sa", $timestamp);


$date = date_create($row[0]);

echo date_format($date, 'Y-m-d H:i:s');
date("Y-m-d H:i:s")
*/

define("BEZNEVROZA", 1);

define("DS", DIRECTORY_SEPARATOR);
define("DEBUG", 1);
define("HOME_DIR", __DIR__);

define("PATH_INCLUDES", HOME_DIR.DS."includes");
define("PATH_TMPL", HOME_DIR.DS."templates");
define("PATH_MEDIA", HOME_DIR.DS."media");

error_reporting(E_ERROR);

include HOME_DIR.DS."config.php";
include PATH_INCLUDES.DS."functions.php";

$document = new Document();

$content = processRequest();
$document->setContent($content);
$document->renderDocument();
