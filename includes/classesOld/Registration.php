<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 15:40
 */
class Registration
{
    static function register($user){

        $user->code = rand(11111, 99999);
        //$user->password = $user->password;



        if(!$result = $user->save())
            die("registrationController::register() : ошибка записи пользователя \n");

        self::sendMail($user);
    }

    static function getForm(){
        $fields = array(
            'phone'      => array('type' => 'phone', 'required'  => false,  'value' => null),
            'firstname'  => array('type' => 'text',  'required'  => true,   'value' => null),
            'email'      => array('type' => 'email', 'required'  => true,   'value' => null),
            'password'   => array('type' => 'text',  'required'  => true,   'value' => null),
            'confirm'    => array('type' => 'text',  'required'  => true,   'value' => null),
            'lastname'   => array('type' => 'text',  'required'  => true,   'value' => null),
            'patronymic' => array('type' => 'text',  'required'  => false,  'value' => null),
            'gender'     => array('type' => 'number','required'  => false,  'value' => null),
            'year'       => array('type' => 'text',  'required'  => true,  'value' => null),
            'mounth'     => array('type' => 'text',  'required'  => true,  'value' => null),
            'day'        => array('type' => 'text',  'required'  => true,  'value' => null),
            'region'     => array('type' => 'text',  'required'  => false,  'value' => null),
            'city'       => array('type' => 'text',  'required'  => false,  'value' => null),
            'street'     => array('type' => 'text',  'required'  => false,  'value' => null),
            'building'   => array('type' => 'text',  'required'  => true,  'value' => null),
            'apartment'  => array('type' => 'text',  'required'  => true,  'value' => null),
            'zipcode'    => array('type' => 'text',  'number'    => true,  'value' => null),
            'skype'      => array('type' => 'text',  'required'  => true,  'value' => null)
        );


        $options = array(
            "fields" => $fields,
            "callback" => array(
                "class" => __CLASS__,
                "method" => 'onvalidateForm'
            )
        );
        $form = new Form($options);
        return $form;
    }

    static function sendMail($user){

        $headers = "Content-type: text/html; charset=utf-8\r\n";
        $content = getEmailTemplate(array(
            "email" => $user->email,
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "urlcode" => getActionLink("registration","confirm", array( "key" => $user->code ))
        ));

        $result = mail($user->email, "Подтверждение регистрации на Beznevrozanet.ru", $content, $headers);
        return $result;
    }

    static function sendRemind($user){
        $headers = "Content-type: text/html; charset=utf-8\r\n";
        $content = getRestoreEmailTemplate(array(
            "email" => $user->email,
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "link" => "http://beznevroza.com/".getActionLink("registration","restorepassword", array( "user" => $user->id ,"key" => $user->password ))
        ));

        $result = mail($user->email, "Восстановление пароля для Beznevrozanet.ru", $content, $headers);
        return $result;
    }

    static function getUserByCode($code){

        $db =  Database::getDB();
        $code = $db->escape($code);

        $result = $db->get("users", "code='$code'");
        if($result && count($result))
            return $result[0];
        else return null;
    }

    static function approveUser($id){
        $result = Database::getDB()->set("users", " code=null , approved=1 ", "id=$id");
        return $result;
    }

    static function onvalidateForm(&$form){

        if(empty($form->validation_errors['password']) && strcmp($form->getField('password'), $form->getField('confirm')))
            $form->validation_errors['password'] = "Пароли не совпадают";

        unset($form->fields['confirm']);

        if(empty($form->validation_errors['email']) && Registration::emailRegistered($form->getField('email')))
            $form->validation_errors['title_message'] = "Пользователь с таким email уже зарегистрирован";
    }

    static function emailRegistered($email){
        $result = Database::getDB()->getOne("users", "email='$email' AND approved=1");
        return !empty($result);
    }

}


