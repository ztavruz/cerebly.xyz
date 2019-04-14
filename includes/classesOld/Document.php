<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 14.02.2017
 * Time: 21:21
 */
class Document{
    private $header_content = "";
    private $content = "";
    private $footer_content = "";

    private static $scripts = array();

    function renderDocument($renderFrame = true){

        if($renderFrame){
            $this->header_content = getHeader();
            $this->footer_content = getFooter();
        }

        echo $this->header_content.$this->content.$this->footer_content;
    }

    function displayError($error_content){

        $this->resetBuffers();

        $this->content = $error_content;

        $this->renderDocument();

        exit;
    }

    function setContent($content){
        $this->content = $content;
    }

    function resetBuffers(){
        while($level = ob_get_level()){
            ob_end_clean();
        }
    }


    static function getTemplate($name, $data = null, $side = false){

        global $config;

        if(!$side)
            $side = defined('ADMIN') ? "admin" : "client";

        $path = PATH_TMPL .DS. $config['default-theme'] .DS. $side .DS. $name .".php";

        ob_start();

        include $path;

        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    static function getAssetsLocation(){
        global $config;

        if(defined("ADMIN"))
            return "../templates/".$config['default-theme']."/assets/";

        return "templates/".$config['default-theme']."/assets/";
    }


    static function sendAjaxResponse($dataObject){
        $content = json_encode($dataObject);
        echo $content;
        exit;
    }

    static function sendResponse($content){
        echo $content;
        exit;
    }

    static public function getScripts()
    {
        return "<script>\n".implode('',static::$scripts)."\n</script>";
    }

    static public function registerJS($script, $id)
    {
        if(isset(static::$scripts[$id])) return;
        static::$scripts[$id] = $script;
    }

}