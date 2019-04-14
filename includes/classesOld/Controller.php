<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 2:16
 */
class Controller{

    private $methods = array();

    public function defaultAction(){
        return __CLASS__.":".__METHOD__;
    }

    public function __construct(){
        $funcs = get_class_methods(get_class($this));

        foreach($funcs as $func){
            if(!substr_compare($func, "Action", -6)){
                array_push($this->methods, substr($func, 0, -6));
            }
        }
    }

    public function haveAction($action = ''){
        return in_array($action, $this->methods);
    }

    public function redirect($controller, $action = '', $params = array() ){
        $url = getActionLink($controller, $action, $params);
        header( 'Location: '.$url );
        die();
    }

}