<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 1:35
 */
class usersController extends Controller{
    
    function defaultAction(){
        $usersdata = User::getUsersTableInfo();
        return Document::getTemplate("users", array(
            "users" => $usersdata
        ));
    }



    function saveAction(){

        User::can('add_user') or die("у вас нет прав для добавления пользователей");

        $user = new User();
        $form = $user->getForm();

        if($form->checkInput()){

            $errors = $form->validate();

            if(empty($errors)){

                $data = $form->getDataArray();

                $user->load($data);

                $user->password = $user->password;

                $user->save();

                return $this->defaultAction();
            }

            $roles = Role::getAll();

            return Document::getTemplate("users-new", array(
                "form" => $form,
                'roles' => $roles
            ));
        }

        return $this->newAction();
    }




    function deleteAction(){

        User::can('delete_user') or die("у вас нет прав для удаления пользователей");

        $id = intval($_REQUEST['id']);
        $db = Database::getDB()->del("users", "id=$id");

        return $this->defaultAction();
    }

    function newAction(){

        User::can('add_user') or die("у вас нет прав для добавления пользователей");

        $user = new User();
        $form = $user->getForm();
        $roles = Role::getAll();
        return Document::getTemplate("users-new", array(
            "form" => $form,
            'roles' => $roles
        ));

    }

    function userAction(){

        User::can('view_user_data') or die("Вы не можете просматривать данные пользователей");

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $user = User::getById($id);
            $abonement = Abonement::getByOwner($user->id);
            $roles = Role::getRolesArray();
            $comments = Comment::getUserComments($user->id);

            if($abonement){
                /*
                $audiosessionsData = Audiosession::getAudiosessionsFromIDString($abonement->asids);
                $plan = Abonement::getPlanFromIDString($abonement->asids);
                $data['start_date'] = $abonement->getStartDate("m.d.Y");
                $data['end_date'] = $abonement->getEndDate("m.d.Y");
                $data['plan'] = $plan;
                $data['audiosessions'] = $audiosessionsData;
                $data['sessions_num'] = count($audiosessionsData);
                $data['duration'] = $abonement->getDurationInterval("j месяцев , n дней");
                $data['intervals'][] = $abonement->interval1;
                $data['intervals'][] = $abonement->interval2;
                $data['intervals'][] = $abonement->interval3; */
                $data['id'] = $abonement->id;

            } else $data = null;



            $options = array(
                "user" => $user,
                "comments_count" => count($comments),
                "abonement" => $data,
                "roles" => $roles
            );

            return Document::getTemplate("user", $options );
        }

        return $this->defaultAction();




    }


    public function chpassAction(){

        User::can('edit_user') or die("у вас нет прав для изменения данных пользователей");

        if(!empty($_REQUEST['id']) && !empty($_REQUEST['password']) ) {

            $id = intval($_REQUEST['id']);
            $pass = $_REQUEST['password'];

            if (!$result = User::changePassword($id, $pass)) {
                //TODO:
            }

            return $this->userAction();
        }
    }

    function chroleAction(){

        (User::can("edit_roles") && User::can('edit_user')) or die("у вас нет прав для изменения данных пользователей");

        if(!empty($_REQUEST['role']) && !empty($_REQUEST['id']) ) {

            $userid = intval($_REQUEST['id']);
            $role = intval($_REQUEST['role']);

            if(!User::changeRole($userid, $role)){
                die("ошибка");
            }

            return $this->userAction();
        }
    }


}