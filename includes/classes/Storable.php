<?php


class Storable{

    public function __construct($settings = array()){
        self::loadSettings($settings, $this);
    }

    static function loadSettings($settings, $object){

        foreach($object as $key => $value)
            if(isset($settings[$key])) $object->$key = $settings[$key];

    }

    static function getAll($class){
        $table = $class::tableName();
        $results = Database::getDB()->get($table);
        $objects = self::getObjects($class, $results);
        return $objects;
    }

    static function getById($class, $id){
        $table = $class::tableName();
        $settings = Database::getDB()->getOne($table, "id=$id");
        return self::getObject($class, $settings);
    }

    static function tableName(){
        die("не указана таблица");
    }

    static function getObject($class, $settings){
        return new $class($settings);
    }

    static function getObjects($class, $array){
        $objects = array();
        foreach($array as $settings){
            $objects[] = new $class($settings);
        }
        return $objects;
    }

}