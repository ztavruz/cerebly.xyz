<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 1:34
 */
class audiosessionsController  extends Controller{

    function defaultAction(){

        if(defined("ADMIN"))
            $audiosessions = Audiosession::getAll();
        else
            $audiosessions = Audiosession::getPublished();

        return Document::getTemplate('audiosessions', array("audiosessions" => $audiosessions));
    }


    function viewAction(){

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $audiosession = Audiosession::getById($id);

            $user = User::getCurrentUser();


            $price = new Price();
            $priceTable = $price->getPriceRows();

            $comments = Comment::getAudiosessionComments($id, 1);

            $commentsContent = Document::getTemplate('comments', array(
                "comments" => $comments,
                "asid" => $audiosession->id,
                "user" => $user
            ));

            $questionanswer = Document::getTemplate("questionanswer");

            $priceTableContent = Document::getTemplate("price-count-table", $priceTable);

            $cardContent = Document::getTemplate('card', array(
                "audiosession" => $audiosession,
                "reviews" => count($comments)
            ));

            $audiosessions = Audiosession::getFullDescription($id);

            return Document::getTemplate('audiosession', array(
                "card" => $cardContent,
                "price-table" => $priceTableContent,
                "comments" => $commentsContent,
                "audiosessions" => $audiosessions,
                "questionanswer" => $questionanswer,
                "comments-count" => count($comments)
                
            ));

        }

        return Document::getTemplate("404", array());

    }



    function addAction(){

        User::can('add_audiosessions') or die("вы не можете добавлять сеансы");

        $options = array(
            "id" => "",
            "caption" => "",
            "description" => "",
            "full_description" => "",
            "uri" => "",
            "img1" => "",
            "img2" => "",
            "img3" => "",
            "img4" => "",
            "published" => 0,
            "blocksize" => EncryptedFile::SECTION_SIZE
        );
        return Document::getTemplate("audiosession-add", $options);

    }

    function saveAction(){

        $errors = array();

        $input_id = !empty($_POST['id']) ? intval($_POST['id']) : null ;

        if(empty($_POST['caption'])) $errors['caption'] = "Вы не указали название аудиосеанса";
        else $input_caption = $_POST['caption'];

        $input_description = empty($_POST['description']) ? '' : $_POST['description'] ;

        $full_description = empty($_POST['full_description']) ? '' : $_POST['full_description'] ;

        $allowed_mime_types = array(
            "image/gif",
            "image/jpeg",
            "image/png"
        );

        if(empty($_POST['uri']))
            $errors['uploadfile'] = "Не выбран файл сеанса";
        else
        {
            $uri = $_POST['uri'];
        }

        /*if(empty($_POST['full_description']))
            $errors['uploadfile'] = "Не выбран файл описания";
        else
        {
            $full_description = $_POST['full_description'];
        }*/

        $img1 = empty($_POST['img1']) ? '' :  $img1= $_POST['img1'];
        $img2 = empty($_POST['img2']) ? '' :  $img1= $_POST['img2'];
        $img3 = empty($_POST['img3']) ? '' :  $img1= $_POST['img3'];
        $img4 = empty($_POST['img4']) ? '' :  $img1= $_POST['img4'];

        try{

            $imgFile = new FileUploader('uploadimage1', PATH_MEDIA.DS."images".DS, null, $allowed_mime_types );
            if($imgFile->load())
            {
                $imgFile->save();
                $img1 = $imgFile->getURL();
            }
        }
        catch (Exception $e)
        {
            $errors['uploadimage1'] = $e->getMessage();
        }

        try{

            $imgFile2 = new FileUploader('uploadimage2', PATH_MEDIA.DS."images".DS, null, $allowed_mime_types );
            if($imgFile2->load())
            {
                $imgFile2->save();
                $img2 = $imgFile2->getURL();
            }
        }
        catch (Exception $e)
        {
            $errors['uploadimage2'] = $e->getMessage();
        }

        try{

            $imgFile3 = new FileUploader('uploadimage3', PATH_MEDIA.DS."images".DS, null, $allowed_mime_types );
            if($imgFile3->load())
            {
                $imgFile3->save();
                $img3 = $imgFile3->getURL();
            }
        }
        catch (Exception $e)
        {
            $errors['uploadimage3'] = $e->getMessage();
        }

        try{

            $imgFile4 = new FileUploader('uploadimage4', PATH_MEDIA.DS."images".DS, null, $allowed_mime_types );
            if($imgFile4->load())
            {
                $imgFile4->save();
                $img4 = $imgFile4->getURL();
            }
        }
        catch (Exception $e)
        {
            $errors['uploadimage4'] = $e->getMessage();
        }

        $published = empty($_POST['published']) ? 0 : 1;

        if(!User::can("publish_audiosessions")){
            if($input_id && ($as = Database::getDB()->getOne("audiosessions", "id=$input_id"))){
                if($published != $as['published']){
                    $errors['uploadfile'] = "вы не можете менять публикации сеансов.";
                    $published = $as['published'];
                }
            } else $published = 0;
        }

        if(!empty($errors)){

            Document::sendAjaxResponse(array(
                "error" => true,
                "errors" => $errors
            ));
        }

        if($input_id) $query = "UPDATE audiosessions SET caption='$input_caption', description='$input_description' , full_description='$full_description',  uri='$uri', img1='$img1', img2='$img2', img3='$img3', img4='$img4', published=$published WHERE id=$input_id";
        else $query = "INSERT INTO audiosessions (caption, description, full_description, uri, img1, img2, img3, img4 ,published) VALUES ( '$input_caption' , '$input_description' , '$full_description', '$uri', '$img1', '$img2','$img3','$img4', $published)";

        $result = Database::getDB()->setQuery($query);

        if(!$input_id) $input_id = Database::getDB()->getLastId();

        Document::sendAjaxResponse(array(
            "error" => false,
            "id" => $input_id
        ));
    }








    function editAction(){

        User::can('edit_audiosessions') or die("вы не можете редактировать сеансы");

        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);

            if($audiosession = Audiosession::getById($id)){

                $options = array(
                    "id" => $id,
                    "caption" => $audiosession->caption,
                    "description" => $audiosession->description,
                    "full_description" => $audiosession->full_description,
                    "uri" => $audiosession->uri,
                    "img1" => $audiosession->img1,
                    "img2" => $audiosession->img2,
                    "img3" => $audiosession->img3,
                    "img4" => $audiosession->img4,
                    "published" => $audiosession->published
                );

                return Document::getTemplate("audiosession-add", $options);

            }
        }
        return $this->addAction();
    }

    function deleteAction(){

        User::can('delete_audiosessions') or die("вы не можете удалять сеансы");

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            if(!Audiosession::delete($id)){
                die("ошибка при удалении аудиосеанса");
            }

            return $this->defaultAction();

        }
    }

    function saveblockAction(){
        if(User::can('block_audiosessions'))
        if(!(empty($_REQUEST['id']) || empty($_REQUEST['start_date']) || empty($_REQUEST['end_date'])) ){


            $id = intval($_REQUEST['id']);
            $start_date = date_create($_REQUEST['start_date']);
            $end_date = date_create($_REQUEST['end_date']);
            $current_date = date_create();

            if($start_date < $end_date && $current_date < $end_date) {

                $audiosession = Audiosession::getById($id);

                $audiosession->blocked = 1;
                $audiosession->blockstart = date_format($start_date, "Y-m-d H:i:s");
                $audiosession->blockend = date_format($end_date, "Y-m-d H:i:s");

                $audiosession->save();
            }
        }

        return $this->defaultAction();
    }

    function freeblockAction(){

        if(!empty($_REQUEST['id'])){


            $id = intval($_REQUEST['id']);

            $udiosession = Audiosession::getById($id);
            $udiosession->blocked = 0;
            $udiosession->blockstart = null;
            $udiosession->blockend = null;
            $udiosession->save();

            return $this->defaultAction();

        }

    }


    function uploadAction()
    {
        global $config;

        session_start();

        // Если запрошен старт загрузки
        if(!empty($_POST['start_upload_session']))
        {
            // если загрузка уже идет
            if(!isset($_SESSION['file']))
            {

                $token = rand(111111, 999999);
                $filename = basename($_POST['filename']).'.encrypted';
                $_SESSION['file'] = array(
                    'upload_file_token' => $token,
                    'filename' => $filename
                );

                $filenameFull = $config['audiosession-storage'].$filename;
                if(file_exists($filenameFull))
                    unlink($filenameFull);

                echo json_encode( array( 'error' => false, 'token' => $token) );

            } else
                echo json_encode( array( 'error' => true, 'message' => 'загрузка уже началась') );

            exit;

        }

        // Если пришло сообщение о конце загрузки
        if(isset($_POST['session_end'])) {

            $fileName = $_SESSION['file']['filename'];
            $storagePath = $config['audiosession-storage'];

            // очистим сессию
            unset($_SESSION['file']);

            // нужно создать заголовок загруженного файла
            try{
                $file = new EncryptedFile($storagePath.$fileName);
                $file->createFileHeader();
                $file->decryptFile($storagePath."forcheck.mp3"); // проверка
            } catch (Exception $e) {
                echo json_encode( array( 'error' => true, 'message' => $e->getMessage() ));
            }

            echo json_encode( array( 'error' => false ));
            exit;
        }

        // Если пришел кусок файла, запишем его
        if(isset($_SESSION['file']) && isset($_FILES['file']))
        {
            try{

                if($_SESSION['file']['upload_file_token'] != $_POST['token'])
                {
                    throw new Exception("неверный token");
                }

                if($_FILES['file']['error'] != 0){
                    throw new Exception("Ошибка загрузки файла");
                }

                $tempName = $_FILES['file']['tmp_name'];
                $fileName = $_SESSION['file']['filename'];
                $storagePath = $config['audiosession-storage'];


                $file = new EncryptedFile($storagePath.$fileName);
                $file->uploadSection($tempName);

                echo json_encode( array( 'error' => false));

            } catch (Exception $e){
                echo json_encode( array( 'error' => true, 'message' => $e->getMessage() ));
            }

            exit;
        }




    }

    // точка входа для плеера
    function sourceAction()
    {
        global $config;
        session_start();

        if(isset($_POST['section'])){

            $block_id = intval($_POST['section']);

            if(isset($_SESSION['audiosession']))
            {
                $filename = $_SESSION['audiosession']['file'];

                $file = new EncryptedFile( $filename );
                echo $file->getSection($block_id);
                exit;

            }
        }

        // Вызывается когда плеер только загрузился на страницу, самый первый вызов
        if(isset($_POST['start']))
        {
            try{

                // если пользователь не авторизован
                if(!$user = User::getCurrentUser()) throw new Exception("вы не авторизованы.");
                if(!$abonement = Abonement::getByOwner($user->id)) throw new Exception("у вас нет абонементов");

                if($audiosession = $abonement->getCurrentAudiosession())
                {
                    $_SESSION['audiosession'] = array(
                        "file" => $config['audiosession-storage'].$audiosession->uri.'.encrypted',
                        "session_id" => $audiosession->id,
                        "abonement_id" => $abonement->id
                    );

                    /*
                     * Добавляем список прослушивания
                     */

                    $listenPlan = $abonement->getCurrentPlan();

                    $planData = array();

                    foreach($listenPlan as $planItem)
                    {
                        /** @var array $audiosession */
                        $audiosession = $planItem[0];
                        /** @var DateTime $timeStart */
                        $timeStart = $planItem['time'];
                        $planData[] = array(
                            'id' => $audiosession['id'],
                            'caption' => $audiosession['caption'],
                            'time' => $timeStart->format("h:i:s"),
                        );
                    }






                    echo json_encode( array(
                        "error" => 0,
                        "caption" => $audiosession->caption,
                        "image" => $audiosession->img1
                    ));
                    exit;
                }


            }
            catch(Exception $e)
            {
                echo json_encode(array(
                    'error' => 1, "message" => $e->getMessage()
                ));
                exit;
            }
        }

        if(isset($_POST['initialization'])){

            $filename = $_SESSION['audiosession']['file'];

            $file = new EncryptedFile( $filename );
            echo $file->getFileInfo();
            exit;
        }


        if (isset($_POST['check_status']))
        {
            if(isset($_SESSION['audiosession']))
            {
                $session_id = $_SESSION['audiosession']['session_id'];

                if($user = User::getCurrentUser()){

                    if($abonement = Abonement::getByOwner($user->id)){

                        if($audiosession = $abonement->getCurrentAudiosession())
                        {
                            if($session_id == $audiosession->id)
                            {
                                echo json_encode( array(
                                    "error" => 0,
                                    "_continue" => 1
                                ));
                                exit;
                            }
                        }
                    }
                }
            }

            echo json_encode( array(
                "error" => 1,
                "_continue" => 0
            ));
            exit;
        }


    }


}