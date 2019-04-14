<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 20.02.2017
 * Time: 7:08
 */
class Role extends Storable
{
    public $id;
    public $caption;
    public $add_user = 0;
    public $delete_user = 0;
    public $edit_user = 0;
    public $view_user_data = 0;
    public $block_user = 0;


    public $add_comments = 1;
    public $review_comments = 0;
    public $delete_comments = 0;

    public $add_audiosessions = 0;
    public $delete_audiosessions = 0;
    public $edit_audiosessions = 0;
    public $publish_audiosessions = 0;
    public $block_audiosessions = 0;
    public $review_statistics = 0;

    public $delete_abonements = 0;
    public $edit_abonements = 0;
    public $block_abonements = 0;
    public $review_history = 0;
    public $admin_access = 0;
    public $edit_roles = 0;

    public function __construct($settings = array()){

        self::loadSettings($settings, $this);
    }

    static function getAll(){
        return parent::getAll(__CLASS__);
    }

    static function getById($id){
        return parent::getById(__CLASS__, $id);
    }

    static function tableName(){
        return "roles";
    }

    static function getRolesArray(){
        $roles = self::getAll();
        $roles_array = array();
        foreach($roles as $role){
            $roles_array[ $role->id ] = $role;
        }

        return $roles_array;
    }

    static function getRightsList(){

        $role = self::getById(1);

        unset($role->id);
        unset($role->caption);

        return get_object_vars($role);
    }

    static function getForm(){

        $list = Role::getRightsList();

        $list['id'] = "";

        $fields = array();
        foreach($list as $key => $value){
            $fields[$key] = array(
                "value" => '0',
                "required" => false,
                'type' => "number"
            );
        }

        $options = array(
            "fields" => $fields,
            "callback" => null
        );

        return new Form($options);

    }

    public function save(){

        return Database::getDB()->save("roles", get_object_vars($this));

    }


}