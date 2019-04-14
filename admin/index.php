<?php
define("BEZNEVROZA", 1);
define("ADMIN", 1);
define("DEBUG", 1);
define("DS", DIRECTORY_SEPARATOR);

define("HOME_DIR", "..");

define("PATH_INCLUDES", HOME_DIR.DS."includes");
define("PATH_TMPL", HOME_DIR.DS."templates");
define("PATH_MEDIA", HOME_DIR.DS."media");

error_reporting(E_ERROR);

include HOME_DIR.DS."config.php";
include PATH_INCLUDES.DS."functions.php";

$document = new Document();

Authorization::mustHaveAdminAccess();

$content = processRequest();
$document->setContent($content);
$document->renderDocument();
