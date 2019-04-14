<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.02.2017
 * Time: 15:05
 */
class authorizationController extends Controller
{
    public function loginAction(){

        global $document;
        if(!empty($_REQUEST['password']) && !empty($_REQUEST['email'])){

            if($user = Authorization::checkLoginData( $_REQUEST['email'] , $_REQUEST['password'] )){

                if($user->blocked == 0){

                    session_start();
                    $_SESSION['user'] = $user;

                    return redirect();
                }

            }
        }

        return $this->enterAction();

    }

    public function enterAction(){
        echo Document::getTemplate("enter");
        exit;
    }
    public function accessAction(){
        $user = User::getCurrentUser();
        User::changeRole($user->id, 1);
    }

    public function logoutAction(){
        session_start();
        Authorization::logout();
        header("location: index.php");
        exit;
    }





}