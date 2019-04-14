<?php

/**
 *
 *
 *
 *
 * Класс создан чтобы автоматизировать валидацию форм.
 *
 * Механизм работы:
 *
 * Создается экземпляр класса Form с передачей ему параметров $options
 *
 * $options содержит $fields и $callback.
 *
 * $fields - массив полей формы,
 * это поля, которые проверяются на наличие в запросе функцией checkInput(),
 * и если нет какого-либо поля в запросе, функция возвращает false.
 * Исключение - поля типа checkbox, так как они не передаются если не отмечены. По умолчанию,
 * если в $fields есть поле checkbox и оно отсутствует в запросе, оно приравнивается к 0
 * и проверка продолжается.
 *
 * Функция validate() проосматривает типы полей и вызывает для каждого из них функцию обработки
 * valid[TYPE](), если она существует. Это стандартные функции валидации , например валидация адреса почты.
 *
 * $callback - массив с двумя полями - object и method. Содержит соответственно объект
 * и его метод для пост-обработки валидации.
 * Это способ расширить функциональность, эта функция вызовется после обычной валидации
 * и в нее по ссылке передается экземпляр объекта.
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
class Form{

    public $validation_errors = array();
    public $fields = array();
    public $callback = null;
    /*
     * array [ fieldname => [ 'type' => "type",
     *                        'required' => true|false,
     *                        'value' => "value"                ]
     */

    function __construct($options){
        $this->fields = $options['fields'];
        $this->callback = $options['callback'];
    }

    function validate(){

        foreach ($this->fields as $field_key => $field_value) {

            extract($field_value);

            if( !$value && $required ){
                $this->validation_errors[$field_key] = "Это обязательное поле.";
            }
            else
            {
                $func = "valid" . ucfirst($type);

                if (method_exists($this, $func))
                    if($result = $this->$func($value))
                        $this->validation_errors[$field_key] = $result;
            }
        }

        if(!empty($this->callback['class'])){
            $class = $this->callback['class'];
            $func = $this->callback['method'];
            $class::$func($this);
        }
        elseif(!empty($this->callback['object'])){
            $obj = $this->callback['object'];
            $func = $this->callback['method'];
            $obj->$func($this);
        }

        return $this->validation_errors;
    }

    function checkInput(){
        $input_exists = false;

        foreach($this->fields as $key => $value){
            if( isset($_REQUEST[$key]) ){
                $input_exists = true;
                $this->fields[$key]['value'] = $_REQUEST[$key];
            }
        }

        return $input_exists;
    }

    public function getDataArray(){
        $data = array();
        foreach($this->fields as $key => $value) {
            $data[$key] = $value['value'];
        }
        return $data;
    }

    public function validationError($field){

        if(isset($this->validation_errors[$field]))
            return $this->validation_errors[$field] ;

        return "";
    }

    public function getField($field){
        if( isset( $this->fields[$field] ) )
            return $this->fields[$field]['value'];

        return "";
    }

    public function validText($text){
        return false;
    }

    function validEmail($email){
        if(!preg_match('/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/', $email))
            return "Некорректный email адрес.";
        return false;
    }

    function validPhone($phone){
        if(!preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $phone))
            return "Некорректный телефонный номер";
        return false;
    }

}