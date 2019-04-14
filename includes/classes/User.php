<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 0:33
 */
class User extends Storable{

    public $id;
    public $firstname;
    public $lastname;
    public $patronymic;
    public $password;
    public $year;
    public $email;
    public $approved = 0;
    public $code;
    public $role = 2;
    public $phone;
    public $mounth;
    public $day;
    public $region;
    public $city;
    public $street;
    public $building;
    public $apartment;
    public $zipcode;
    public $skype;
    public $register_time;
    public $gender;
    public $blocked = 0;
    public $blockstart;
    public $blockend;
    public $blocks = null;
    public $rights = null;

    public function __construct($settings = array()){

        self::loadSettings($settings, $this);
    }

    public function save(){
        $db = Database::getDB();
        $tableName = User::tableName();

        $vars = get_object_vars($this);

        unset($vars['register_time']);
        unset($vars['blocks']);
        unset($vars['rights']);

        return $db->save($tableName, $vars);
    }

    public function authorized(){
        return $this->authorized;
    }

    static function getCurrentUser(){

        static $current_user = null;

        if(!$current_user)
        {
            $current_user = Authorization::getCurrentUser();
        }

        return $current_user;
    }

    static function getAll(){
        return parent::getAll(__CLASS__);
    }

    static function getById($id){
        return parent::getById(__CLASS__, $id);
    }


    static function tableName(){
        return "users";
    }

    public function getAge(){
        if($this->day && $this->mounth && $this->year){
            $birthday = date_create_from_format("j n Y", "{$this->day}  {$this->mounth}  {$this->year}");
            $today = date_create();
            $interval = date_diff($today, $birthday);
            return $interval->y;
        } else return "не указан";
    }

    public function getForm(){

        $fields = array(
            'id'        => array( 'type' => 'text', 'required' => false, 'value' => $this->id),
            'firstname' => array( 'type' => 'text', 'required' => true,  'value' => $this->firstname),
            'lastname'  => array( 'type' => 'text', 'required' => true,  'value' => $this->lastname),
            'patronymic'=> array( 'type' => 'text', 'required' => false, 'value' => $this->patronymic),
            'password'  => array( 'type' => 'text', 'required' => true,  'value' => ""),
            'day'       => array( 'type' => 'text', 'required' => false, 'value' => $this->day),
            'mounth'    => array( 'type' => 'text', 'required' => false, 'value' => $this->mounth),
            'year'      => array( 'type' => 'text', 'required' => false, 'value' => $this->year),
            'email'     => array( 'type' => 'email','required' => false, 'value' => $this->email),
            'role'      => array( 'type' => 'text', 'required' => false, 'value' => $this->role),
            'phone'     => array( 'type' => 'phone','required' => false, 'value' => $this->phone),
            'region'    => array('type'  => 'text', 'required' => false, 'value' => $this->region),
            'city'      => array('type'  => 'text', 'required' => false, 'value' => $this->city),
            'street'    => array('type'  => 'text', 'required' => false, 'value' => null),
            'apartment' => array('type'  => 'text', 'required' => false, 'value' => null),
            'zipcode'   => array('type'  => 'text', 'number'   => false, 'value' => null),
            'skype'     => array( 'type' => 'text', 'required' => false, 'value' => $this->skype),
            'gender'    => array( 'type' => 'text', 'required' => false, 'value' => $this->gender)
        );

        if(!defined("ADMIN")) {
            $fields['confirm_password'] = array('type' => 'text', 'required' => true, 'value' => "");
        }

        $callback = array(
            "object" => $this,
            "method" => "onvalidate"
        );

        $options = array(
            "fields" => $fields,
            "callback" => $callback
        );

        $form = new Form($options);
        return $form;

    }


    public function load($settings){
        self::loadSettings($settings, $this);
    }


    public function onvalidate(&$form){

        if(empty($form->fields['password']['value']))
            $form->validation_errors['password'] = "Введите пароль";
        else if(isset($form->fields['confirm_password']) && $form->fields['confirm_password']['value'] != $form->fields['password']['value'] )
            $form->validation_errors['confirm_password'] = "пароли не совпадают";

        if(!empty($form->fields['email']['value'])) {

            $email = $form->fields['email']['value'];

            if(Registration::emailRegistered($email))
                $form->validation_errors['email'] = "email уже зарегистрирован";
        }

        return;
    }


    static function getUsersTableInfo(){
        $query = "SELECT users.id, users.email, users.firstname, users.lastname, users.register_time, (SELECT roles.caption FROM roles WHERE users.role = roles.id) AS role , (SELECT COUNT(*) FROM comments WHERE users.id=comments.userid) AS comments_count, (SELECT COUNT(*) FROM blocks WHERE users.id=blocks.user_id) AS blocks_count FROM users";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }

    static function changePassword($id, $pass){
        return Database::getDB()->set("users", " password = '$pass' ", " id=$id ");
    }


    public function haveAccess($right){
        if($this->rights === null) $this->rights = Role::getById($this->role);
        if(isset($this->rights->$right)){
            if($this->rights->$right && !checkBlocks($this, $right)){
                return 1;
            }
        }

        return 0;
    }


    static function can($right){
        $user = User::getCurrentUser();
        return $user->haveAccess($right);
    }

    static function changeRole($userid, $roleid){

        if($roleid && $userid && $user = User::getById($userid)){

            if($user->role == $roleid) return true;

            if($role = Role::getById($roleid)){

                $user->role = $role->id;

                if($user->save()) return true;
            }
        }

        return false;
    }


}