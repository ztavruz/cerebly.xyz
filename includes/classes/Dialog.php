<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 13.07.2017
 * Time: 15:04
 */
class Dialog
{
    public $messages = [];

    public static function getDialog($question_id)
    {
        $query = "SELECT * FROM dialog_messages WHERE question_id=$question_id ORDER BY time ";
        $messages = Database::getDB()->getQuery($query);
        return $messages;
    }

    /**
     * @param DateTime $datetime
     * @param $question_id
     * @return array
     */
    public static function getMessagesFrom($datetime, $question_id)
    {
        $query = "SELECT * FROM dialog_messages WHERE question_id=$question_id AND time > '{$datetime->format("Y-m-d H:i:s")}';";
        $results = Database::getDB()->getQuery($query);
        return $results;
    }

}