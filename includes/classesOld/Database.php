<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 14.02.2017
 * Time: 20:00
 */
class Database extends Storable
{

    static $db = null;


    public $database = '';
    public $username = '';
    public $password = '';
    public $host = '';

    private $mysqli = null;

    static function getDB(){
        if(!self::$db){
            self::$db = new Database();
        }
        return self::$db;
    }

    public function __construct(){
        global $config;

        $this->database = $config['db']['database'];
        $this->username = $config['db']['username'];
        $this->password = $config['db']['password'];
        $this->host     = $config['db']['host'];

        $this->connect();

    }

    private function connect(){

        $db = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if($db->connect_errno){
            die("Не удалось подключиться к MySQL: ". $db->connect_error );
        }

        if (!$db->set_charset("utf8")) {
            die("Ошибка при загрузке набора символов utf8: ". $db->error);
        }

        $this->mysqli = $db;
    }

    function getQuery($query){

        if(!$res = $this->mysqli->query($query)) die($this->mysqli->error);

        $result = array();
        while($row = $res->fetch_assoc())
            array_push ($result, $row);

        return $result;
    }

    function setQuery($query){
        if(!$res = $this->mysqli->query($query)) die($this->mysqli->error);
        return $res;
    }

    /**
     * Возвращает из базы данных количество записей.
     *
     * @param string $table Имя таблицы
     * @param string $where Необязательный параметр. Условия выборки
     * @return integer
     */
    function get($table, $where = null){
        $query = "SELECT * FROM ".$table.($where ? " WHERE ".$where : "") ;
        return $this->getQuery($query);
    }

    function getCount($table, $where = null){

        if($where){
            $where = " WHERE ".$where;
        } else {
            $where = "";
        }

        $temp = $this->getQuery("SELECT COUNT(1) AS count FROM $table".$where);

        return $temp[0]['count'];
    }

    /**
     * Возвращает первый результат выполнения запроса
     *
     * @param type $table Имя таблицы
     * @param type $where Критерий поиска
     * @return array Результат запроса
     */
    function getOne($table, $where){
        $result = $this->get($table,$where);
        if(count($result))return $result[0];
        return $result;
    }

    /**
     * Добавляет новую запись в таблицу.
     *
     * @param string $table Имя таблицы
     * @param object $object Имена полей - ключи массива.
     * @return boolean Результат запроса
     */
    function insert($table, $names, $values){
        $query = "INSERT INTO $table ($names) VALUES ($values)";
        $result = $this->setQuery($query);
        return $result;
    }

    /**
     * Удаляет запись из таблицы
     *
     * @param string $table Имя таблицы
     * @param string $where Условия
     * @return boolean Результат запроса
     */
    function del($table, $where){
        $query = "DELETE FROM $table WHERE $where";
        $result = $this->setQuery($query);
        return $result;
    }

    /**
     * Возвращает последний созданный id
     *
     * @return integer Последний втавленный ID
     */
    function getLastId(){
        return $this->mysqli->insert_id;
    }

    /**
     * Обновляет значения записи в таблице
     *
     * @param string $table Имя таблицы
     * @param string $values Значения в формате "name1=val1 , name2=val2"
     * @param string $where Критерий поиска
     * @return boolean Результат запроса
     */
    function set($table, $values ,$where){
        $query = "UPDATE $table SET $values WHERE $where";
        $result = $this->setQuery($query);
        return $result;
    }

    function remove($table, $id){
        $query = "DELETE FROM $table WHERE id=$id";
        $result = $this->setQuery($query);
        return $result;
    }

    public function save($table, $fields){

        $id = $fields['id'];
        unset($fields['id']);


        $vars = array();
        $names = array();
        $values = array();

        foreach($fields as $key => $value){

            if($value === '' || $value === null) $val = 'null';
            //elseif($value == '0') $val = 0;
            else $val = "'".$value."'";

            $vars[] = $key."=".$val;
            $names[] = $key;
            $values[] = $val;
        }

        if(!empty($id))
        {
            $vars = implode(',', $vars);
            return $this->set($table, $vars, "id=$id");
        }
        else
        {
            $names = implode(',', $names);
            $values = implode(',', $values);
            return $this->insert($table, $names, $values);
        }
    }

    public function escape($str){
        return $this->mysqli->real_escape_string($str);
    }

    public function setArray($table, $array, $where){
        $data = array();
        foreach($array as $key => $value)
            $data[] = " $key = $value ";

        $vars = implode(',', $data);

        return $this->set($table, $vars, $where);
    }

    public function insertArray($table, $data){

        $names = implode(',', array_keys($data));
        $values = implode(',', array_values($data));

        return $this->insert($table, $names, $values);

    }
}