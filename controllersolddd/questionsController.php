<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 11.08.2017
 * Time: 22:10
 */


class questionsController extends Controller{

   public $id;
   public $id_q;

 function defaultAction()
    {       
        $id = intval($_REQUEST['id']);
        $question = Sendmail::getUsersQuestions($id);

        return Document::getTemplate('answer', array('questions' => $question,'id_q' => $id ));
    }
 

 function answerAction()
    {
        $answer = $_POST['message'];
        $id_q = intval($_REQUEST['id']);
        Sendmail::setAnswer($answer,$id_q);
        $is_ok = Sendmail::sendAnswer($answer,$id_q);
        return Document::getTemplate('attention', array('isok' => $is_ok));
    }

 function deleteAction()
    {
        User::can('delete_user') or die("у вас нет прав для удаления пользователей");

        $id = intval($_REQUEST['id']);
        $db = Database::getDB()->del("questions", "id=$id");

        return Document::getTemplate('good_del',array('isok' => $db ));
    }

 function сorrespondenceAction()
    {
        $id = intval($_REQUEST['id']);

        $mail = Sendmail::getMailUser($id);
        $questions = Sendmail::getAnswersUser($mail);

        return Document::getTemplate('сorrespondence',array('questions' => $questions));
    }

 function historymailsAction()
    {
        $id = intval($_REQUEST['id']);

        $mail = Sendmail::getMailsForUser($id);
        $questions = Sendmail::getAnswersAdmin($mail);

        return Document::getTemplate('history_mails',array('questions' => $questions));
    }


}
