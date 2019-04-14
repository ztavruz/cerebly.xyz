<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 26.02.2017
 * Time: 23:59
 */
class rolesController extends Controller
{
    public function createAction(){

        if(!empty($_REQUEST['rolename'])){

            $name = Database::getDB()->escape($_REQUEST['rolename']);

            $role = new Role( array(
                "caption" => $name
            ) );

            $role->save();

            return $this->defaultAction();
        }


    }

    public function editAction(){

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $role = Role::getById($id);

            return Document::getTemplate("edit_role", array(
                "role" => $role
            ));
        }

        return $this->defaultAction();

    }

    public function defaultAction(){

        $roles = Role::getAll();

        return Document::getTemplate("roles", array(
            "roles" => $roles
        ));

    }


    public function deleteAction(){

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            if($id == 1 || $id == 2) return $this->defaultAction(); //роли id = 1 и 2 удалять нельзя . Это суперадмин и посетитель.

            Database::getDB()->del("roles", "id=$id");
        }

        return $this->defaultAction();

    }

    public function saveAction(){

        $data = array();
        $caption = null;
        if(!empty($_REQUEST['caption'])){
            $caption = Database::getDB()->escape($_REQUEST['caption']);
        } else {
            return $this->defaultAction();
        }

        $id = null;

        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);
        }

        $role = new Role();
        $vars = get_object_vars($role);

        unset($vars['caption']);
        unset($vars['id']);

        foreach($vars as $key => $val){

            if(!empty($_REQUEST[$key])){
                $data[$key] = intval($_REQUEST[$key]);
            }

        }

        $data['caption'] = $caption;

        if($id) $data['id'] = $id;

        $role = new Role($data);

        $role->save();

        return $this->defaultAction();

    }

}