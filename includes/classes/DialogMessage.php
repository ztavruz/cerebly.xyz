<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 13.07.2017
 * Time: 16:51
 */
class DialogMessage extends Storable
{
    public $id;
    public $content;
    public $owner_id;
    public $question_id;

    public function save()
    {
        if(empty($this->id))
        {
            // insert
            $query = "INSERT INTO dialog_messages(content, owner_id, question_id) VALUES ('$this->content', $this->owner_id, $this->question_id);";
        }
        else
        {
            // update
            $query = "UPDATE dialog_messages SET content='{$this->content}', owner_id={$this->owner_id}, question_id={$this->question_id} WHERE id={$this->id} ;";
        }

        $db = Database::getDB();
        if($db->setQuery($query));
        {
            $this->id = Database::getDB()->getLastId();
            return true;
        }
        return false;
    }

}