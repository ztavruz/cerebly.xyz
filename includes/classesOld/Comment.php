<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 0:34
 */
class Comment extends Storable
{
    public $id = null;
    public $userid;
    public $audiosessionid;
    public $content;
    public $time;
    public $approved = 0;


    public function __construct(array $settings = array())
    {
        parent::__construct($settings);
    }

    public function save(){
        if(!$this->id)
            return Database::getDB()->insert("comments", "userid, audiosessionid, content, approved", "{$this->userid}, {$this->audiosessionid}, '{$this->content}', {$this->approved}");
        else
            return Database::getDB()->set("comments", "userid={$this->userid}, audiosessionid={$this->audiosessionid}, content='{$this->content}', approved={$this->approved}", "id={$this->id}");
    }

    static function getAll(){
        return parent::getAll(__CLASS__);
    }

    static function getById($id){
        return parent::getById(__CLASS__, $id);
    }


    static function tableName(){
        return "comments";
    }

    static function getAudiosessionComments($audiosessionid, $approved = null){

        if($approved !== null) $approved_query = " and comments.approved = ".$approved;
        else $approved_query = "";

        $query = "SELECT comments.content, comments.time, users.firstname, users.lastname from users, comments where comments.audiosessionid = $audiosessionid and users.id = comments.userid".$approved_query;
        $comments = Database::getDB()->getQuery($query);
        return $comments;
    }

    static function getUserComments($userid){
        $query = "SELECT comments.id, comments.content, comments.time, users.firstname, users.lastname from users, comments where users.id=$userid and users.id = comments.userid";
        $comments = Database::getDB()->getQuery($query);
        return $comments;
    }


    static function getAllExtendedData($approved = null){

        if($approved !== null)
            $approved_query = " and comments.approved = ".$approved;
        else
            $approved_query = "";

        $query = "SELECT comments.id, comments.content, comments.time, comments.approved, users.firstname, users.lastname, audiosessions.caption from users, comments, audiosessions where users.id = comments.userid and comments.audiosessionid = audiosessions.id ".$approved_query;
        $comments = Database::getDB()->getQuery($query);
        return $comments;
    }

    static function delete($id){
        return Database::getDB()->del("comments", "id=$id");
    }


    static function approve($id){
        return Database::getDB()->set("comments", "approved=1", "id=$id");
    }
}