<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 18:23
 */
class registrationController extends Controller{

    public function defaultAction(){

        if(defined("ADMIN")){
            header("location: http://beznevrozanet.ru/".getActionLink("registration"));
            exit;
        }

        $form = Registration::getForm();

        if($form->checkInput()){

            $errors = $form->validate();

            if(empty($errors)){

                $data = $form->getDataArray();

                $user = new User($data);

                Registration::register($user);

                return Document::getTemplate("confirm_email", array('confirm_code' => $user->code));

            }
        }

        return Document::getTemplate('registration_form', $form);
    }







    public function confirmAction(){

        if(isset($_GET['key'])){
            if($user = Registration::getUserByCode($_GET['key'])){
                Registration::approveUser($user['id']);

                return Document::getTemplate("registration_confirm");
            }
        }

        header("location: index.php");

    }


    public function forgetAction(){

        if(defined("ADMIN")){
            header("location: http://beznevrozanet.ru/".getActionLink("registration", "forget"));
            exit;
        }

        return Document::getTemplate("forget_email");


    }


    public function remindAction(){

        if(!empty($_REQUEST['email'])){

            $db = Database::getDB();

            $email = $db->escape($_REQUEST['email']);
            if($userdata = $db->getOne("users", "email='$email' and approved=1 ")){
                $user = new User($userdata);

                Registration::sendRemind($user);

                return Document::getTemplate("forget_email", array( "email-sended" => true));

            }

            return Document::getTemplate("forget_email", array( "wrong-email" => true ));

        }

        return Document::getTemplate("forget_email");
    }


    function restorepasswordAction(){

        $db = Database::getDB();

        if(!empty($_REQUEST['key']) && !empty($_REQUEST['user'])){

            $db = Database::getDB();
            $key = $db->escape($_REQUEST['key']);
            $user_id = intval($_REQUEST['user']);

            $user = User::getById($user_id);

            $pass = $user->password;

            if($key == $pass){

                // Заблокирован ли пользователь
                if($user->blocked) {

                    // Истекла ли блокировака

                    $curdate = date_create();
                    $endblock = date_create($user->blockend);

                    if($curdate > $endblock) {
                        // снимаем блокировку

                        if(!$db->set("users", "blocked=0 and blockend=null and blockstart=null")) {

                        }
                    }
                }

                session_start();
                $_SESSION['user'] = $user;

                return Document::getTemplate("forget_email", array("restore-password" => true));

            }

        } elseif(!empty($_REQUEST['password']) && !empty($_REQUEST['confirm_password'])) {

            if( $user = User::getCurrentUser() )
            {
                $password = $db->escape($_REQUEST['password']);
                $confirmPassword = $db->escape($_REQUEST['confirm_password']);

                if($password == $confirmPassword){

                    $user->password = $password;
                    if($user->save()){

                        return Document::getTemplate("forget_email", array("password-changed-success" => true, "restore-password" => true));
                    }

                }

                return Document::getTemplate("forget_email", array("restore-password" => true, "errors" => array( "password" => "Пароли не совпадают" )));
            }
        }

        return $this->remindAction();
    }


}