 <?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 11.08.2017
 * Time: 23:00
 */
class Sendmail
{
    public $id_q;
    public $qestion;
	public $answer;

    static function getQuestionID($id_q){
        $query = "SELECT * FROM faq WHERE id = $id_q";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }


    static function getQuestionUser($qestion){
        $query = "SELECT * FROM faq WHERE question = '$qestion'";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }

    static function getAnswerAdmin($mail){
        $query = "SELECT * FROM faq WHERE answer = '$answer'";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }


    
}