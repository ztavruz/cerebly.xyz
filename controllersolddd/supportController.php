<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 12.07.2017
 * Time: 21:58
 */
class supportController extends Controller
{

    function defaultAction()
    {
        $page = empty($_GET['page']) ? '' : intval($_GET['page']) ;
        $limit = 10;

        $questions = Question::getQuestions($limit, $page);
        return Document::getTemplate('questions', array( 'questions' => $questions ));
    }


    function chatAction()
    {

        try{

            $question_id = empty($_GET['id']) ? '' : $_GET['id'] ;
            if($question_id === '') throw new Exception('не указан ID вопроса');

            $user = User::getCurrentUser();

            if(empty($user))
                return Document::getTemplate('404');

            $question = Question::getById($question_id);
            $dialog = Dialog::getDialog($question->id);
            return Document::getTemplate('chat', array('dialog' => $dialog, 'question' => $question, 'user' => $user ));


        }
        catch(Exception $e)
        {
            return Document::getTemplate('404');
        }


    }

    public function supportAction()
    {

        $user = User::getCurrentUser();
        if(empty($user))
            return Document::getTemplate('404');

        $questions = Question::getQuestionsByUserID($user->id);

        return Document::getTemplate('support', array( 'questions' => $questions));
    }

    public function createAction()
    {
        $q_categories = getQuestionCategories();
        return Document::getTemplate('create', array( 'question_category' => $q_categories ));
    }


    public function messageAction()
    {
        try{
            $content = empty($_POST['content']) ? '' : $_POST['content'] ;
            $id = empty($_POST['id']) ? '' : $_POST['id'] ;

            if(empty($id)) throw new Exception('не указан идентификатор вопроса');
            if(empty($content)) throw new Exception('сообщение не содержит контента');


            $user = User::getCurrentUser();
            if(empty($user))
                throw new Exception('такого пользователя нет');

            $message = new DialogMessage();
            $message->content = $content;
            $message->question_id = $id;
            $message->owner_id = $user->id;

            if(!$message->save())
                throw new Exception('ошибка при сохранении');

            Document::sendAjaxResponse(
                array(
                    'ok' => true,
                    'content' => $message->content,
                    'id' => $message->id ,
                    'update_time' =>  date_create()->format('Y.d.m H:i:s')
                ));
            // TODO: синхронизировать время
        }
        catch(Exception $e)
        {
            Document::sendAjaxResponse(  array( 'ok' => false, 'message' => $e->getMessage() ) );
        }
    }



    public function updateAction()
    {
        try{

            $user = User::getCurrentUser();
            if(empty($user)) throw new Exception('пользователь не найден');

            $last_update = empty($_POST['last_update']) ? '' : $_POST['last_update'];
            $question_id = empty($_POST['id']) ? '' : $_POST['id'];

            if($last_update == '') throw new Exception('необходим параметр последнего обновления');

            $lastUpdate = date_create_from_format('Y.m.d H:i:s', $last_update);

            if($question_id == '') throw new Exception('необходим параметр ID вопроса');

            $messages = Dialog::getMessagesFrom($lastUpdate,  $question_id);

            $hasNew = false;
            foreach($messages as $message)
            {
                if($message['owner_id'] != $user->id) $hasNew = true;
            }

            $content = Document::getTemplate('chat-messages', array('messages' => $messages, 'user' => $user ));
            Document::sendAjaxResponse(array('ok' => true, 'content' => $content, 'update_time' =>  date_create()->format('Y.m.d H:i:s'), 'hasNew' => $hasNew ));
        }
        catch(Exception $e)
        {
            Document::sendAjaxResponse(array('ok' => false, 'message' => $e->getMessage() ));
        }



    }


    public function askAction()
    {
        try{

            $user = User::getCurrentUser();
            if(empty($user)) throw new Exception('пользователь не найден');

            $content = empty($_POST['content']) ? '' : $_POST['content'];
            $category = empty($_POST['category']) ? '' : $_POST['category'];

            if($content == '') throw new Exception('пустое сообщение');
            if($category == '') throw new Exception('необходим параметр category');

            $question = new Question();
            $question->category = $category;
            $question->content = $content;
            $question->user_id = $user->id;

            if(!$question->save())
                throw new Exception('Ошибка сохранения');

            $this->redirect('support', 'create');
        }
        catch(Exception $e)
        {
            $questions = Question::getQuestions();
            return Document::getTemplate('support', array( 'questions' => $questions, 'error' => $e->getMessage() ));
        }
    }

}
