<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 3:30
 */
class Authorization
{

    static function checkLoginData($email, $pass){

        $db = Database::getDB();

        $pass = $db->escape($pass);
        $email = $db->escape($email);

        $pass = md5($pass);

        $user = Database::getDB()->getOne("users", " email='$email' AND password='$pass' AND approved=1");

        if(!empty($user)){
            return new User($user);
        } else {
            return null;
        }


    }

    static function getCurrentUser(){
        session_start();
        if(!empty($_SESSION['user']))
            return $_SESSION['user'];
        else
            return null;
    }

    static function logout(){
        unset($_SESSION['user']);
    }

    static function mustHaveAdminAccess(){

        if($user = Authorization::getCurrentUser()){

            $role = Role::getById($user->role);

            if(!$role->admin_access) die("У вас нет доступа к этому разделу");

            return true;

        }

        global $config;

        $con = $config['controller-label'];
        $act = $config['action-label'];

        $route = "{$_GET[$con]} => {$_GET[$act]}";

        if(!in_array($route, array(
            "ajax => login",
            "authorization => login"
        )))
        {
            $_GET[$con] = "authorization";
            $_GET[$act] = "enter";
        }


        return false;
    }

}