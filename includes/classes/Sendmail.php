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
    public $answer;
    public $id_a;
    public $mail;

    static function getUsersQuestions($id_q){
        $query = "SELECT * FROM questions WHERE id = $id_q";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }

    static function setAnswer($answer,$id_a){
        $query = "UPDATE questions SET answer='$answer' WHERE id = $id_a";
        $result = Database::getDB()->setQuery($query);
        return $result;
    }

    static function getMailUser($id){
        $query = "SELECT email FROM questions WHERE id = $id";
        $result = Database::getDB()->getQuery($query);
        foreach ($result as $key){
            $email = $key['email']; 
        }
        return $email;
    }

    static function getAnswersUser($mail){
        $query = "SELECT * FROM questions WHERE email = '$mail'";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }

    static function getAnswersAdmin($mail){
        $query = "SELECT * FROM questions WHERE email = '$mail'";
        $result = Database::getDB()->getQuery($query);
        return $result;
    }

    static function getMailsForUser($id){
        $query = "SELECT email FROM questions WHERE user_id = $id";
        $result = Database::getDB()->getQuery($query);
        foreach ($result as $key){
            $email = $key['email']; 
        }
        return $email;
    }


    static function sendAnswer($answer,$id_a){

        $query = "SELECT email FROM questions WHERE id = $id_a";
        $mail = Database::getDB()->getQuery($query);

        foreach ($mail as $key){
            $to = $key['email']; 
        }
        $subject = 'Ответ от Beznevrozanet.ru!';
        $message = $answer;
        $headers ='Content-type: text/html; charset=utf-8' . "\r\n".
            'From: beznevrozanet@admin.ru' . "\r\n";

        $result = mail($to, $subject, $message, $headers);
        return $result;

    }

    
}