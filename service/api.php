<?php

$vkURL = "https://api.vk.com/api.php?oauth=1&method=";

if(!isset($_REQUEST['act'])) exit;

$action = $_REQUEST['act'];

$funcName = 'act'.ucfirst($action);

$funcName();

function actCountry(){
    global $vkURL;
    $contents = file_get_contents($vkURL."database.getCountries&v=5.5&need_all=1&count=1000");
    echo $contents;
    exit;
}

function actRegions(){
    global $vkURL;

    if(isset($_REQUEST['cid'])) $cID = intval($_REQUEST['cid']);

    $contents = file_get_contents($vkURL."database.getRegions&country_id=$cID&count=1000");
    echo $contents;
    exit;
}

function actCities(){
    global $vkURL;

    if(isset($_REQUEST['cid'])) $cID = intval($_REQUEST['cid']);
    if(isset($_REQUEST['rid'])) $rID = intval($_REQUEST['rid']);
    if(isset($_REQUEST['offset'])) $offset = intval($_REQUEST['offset']);

    $offset = 1000*$offset;

    $contents = file_get_contents($vkURL."database.getCities&country_id=$cID&region_id=$rID&count=1000&offset=$offset");
    echo $contents;
    exit;
}

echo json_encode(array("content" => "не верный параметр"));