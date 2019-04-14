<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 1:36
 */
class commentsController  extends Controller{

    public function defaultAction(){

        User::can('review_comments') or die("Вы не можете просматривать комментарии");

        return $this->searchAction();

    }

    public function searchAction(){

        User::can('review_comments') or die("Вы не можете просматривать комментарии");

        if($_REQUEST['filter'] == 'noapproved') $filter = 0;
        elseif($_REQUEST['filter'] == 'approved') $filter = 1;
        else $filter = null;

        $comments = Comment::getAllExtendedData($filter);
        return Document::getTemplate("comments", array(
            "comments" => $comments,
            "filter" => $filter
        ));
    }




    public function deleteAction(){

        User::can('delete_comments') or die("Вы не можете удалять комментарии");

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            Comment::delete($id);

            return $this->defaultAction();

        }

    }


    public function approveAction(){

        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);

            Comment::approve($id);

            return $this->defaultAction();
        }

    }


    public function addAction(){

        User::can('add_comments') or die("Вы не можете оставлять комментарии");

        if( !empty($_REQUEST['id']) && !empty($_REQUEST['asid']) && !empty($_REQUEST['content']) ){

            $userid = intval($_REQUEST['id']);
            $audiosessionid = intval($_REQUEST['asid']);
            $content = Database::getDB()->escape( $_REQUEST['content'] );

            $comment = new Comment(array(
                "userid" => $userid,
                "audiosessionid" => $audiosessionid,
                "content" => $content
            ));

            if($comment->save()){

            }

            header("location: ".getActionLink("audiosessions", "view", array("id" => $audiosessionid)));
            exit;
        }

    }

    public function viewcommentsAction() {

        User::can('review_comments') or die("Вы не можете просматривать комментарии");

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $user = User::getById($id);

            $comments = Comment::getUserComments($id);

            return Document::getTemplate("user-comments", array(
                "comments" => $comments,
                "user" => $user
            ) );
        }

        return Document::getTemplate("404", array());
    }



}