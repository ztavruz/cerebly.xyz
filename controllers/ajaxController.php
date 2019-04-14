<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 4:28
 */
class ajaxController extends Controller
{
    function getblocksAction(){

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $blockscontent = getBlockWindowContent($id);


            $response = array(
                "error" => false,
                "content" => $blockscontent
            );

            Document::sendAjaxResponse($response);
        }

        Document::sendAjaxResponse(array(
            "error" => true,
            "content" => "no ID"
        ));

    }

    public function preparepayformAction()
    {
        try{

            if (!$user = User::getCurrentUser())
                throw new Exception("Пользователь не авторизован");

            // Удалим неоплаченные абонементы этого пользователя
            Database::getDB()->del("abonements", "id={$user->id} and paid=0");

            if ($abonement = Abonement::getByOwner($user->id, 1))
                throw new Exception("У пользователя уже есть абонемент");

            $options = Abonement::validate($_POST);
            $options["owner"] = $user->id;

            $abonement = new Abonement($options);

            // Определим срок, когда удалить абонемент из базы, если его не оплатят
            $abonement->expired = Intervals::DaysFromNow(3);

            $intervals = $options['intervals'];

            // Определим начало абонемента
            $abonement->started = Intervals::closestIntervalStartDatetime(
                $abonement->expired,
                $intervals
            );

            // Определим конец абонемента
            $abonement->ending = Intervals::getEndByDuration(
                $abonement->started,
                $intervals,
                $abonement->duration,
                $abonement->times
            );

            $abonement->setIntervals($intervals);
            $abonement->expired = Format::MSDateTime($abonement->expired);
            $abonement->started = Format::MSDateTime($abonement->started);
            $abonement->ending = Format::MSDateTime($abonement->ending);

            if(!$abonement->save())
                throw new Exception("Ошибка сохранения абонемента");

            $price = new Price();
            $content = $price->getPayForm($abonement);

            Document::sendAjaxResponse( array( "error" => false, "content" => $content ));

        } catch (Exception $e) {
            Document::sendAjaxResponse( array( "error" => true, "content" => $e->getMessage(), 's' => $e->getFile() ));
        }
    }




    public function saveblocksAction(){

        User::can('block_user') or die(json_encode(array("error" => true, "content" => "вы не можете изменять блокировки пользователей")));

        $form = Role::getForm();

        if($form->checkInput()){
            // TODO: обработка переданных данных

            $data = $form->getDataArray();

            saveBlocksArray($data);

        }
        header("location: ".getActionLink("users"));
        exit;
    }


    public function loginAction(){

        if(!empty($_REQUEST['password']) && !empty($_REQUEST['email'])){

            if($user = Authorization::checkLoginData( $_REQUEST['email'] , $_REQUEST['password'] )){

                if($user->blocked == 0)
                {
                    Document::sendAjaxResponse(array(
                        "error" => false,
                    ));
                }


            }
        }

        Document::sendAjaxResponse(array(
            "error" => true,
            "content" => "Неправильный email или пароль"
        ));
    }


    public function sessionlistAction(){

        $list = Database::getDB()->get("audiosessions", "published=1 and blocked=0");
        $layout = getAudiosessionWindowList($list);
        Document::sendAjaxResponse(array(
            "error" => false,
            "list" => $layout
        ));


    }

    public function sessiondetailsAction(){

        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);
            $as = Audiosession::getById($id);

            $content = getDetailsWindowContent($as);

            Document::sendAjaxResponse(array(
                "error" => false,
                "content" => $content
            ));

        }
    }


    public function sheduleAction(){

        if(!empty($_REQUEST['start_time']) && !empty($_REQUEST['end_time']) && !empty($_REQUEST['id'])){

            if(($start_datetime = date_create($_REQUEST['start_time'])) && ($end_datetime = date_create($_REQUEST['end_time'])) ){

                if($start_datetime < $end_datetime){

                    $id = intval($_REQUEST['id']);

                    $abonement = Abonement::getById($id);

                    $shedule = Intervals::getSheduleList($abonement, $start_datetime, $end_datetime);

                    $content = getSheduleListBlock($shedule);

                    Document::sendAjaxResponse(array(
                        "error" => false,
                        "content" => $content
                    ));

                }
            }
        }

        Document::sendAjaxResponse(array(
            "error" => true,
            "content" => "Для такого интервала аудиосессии не найдены"
        ));


    }

    public function getblockAction(){
        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);

            $abonement = Abonement::getById($id);

            Document::sendAjaxResponse(array(
                "error" => false,
                "block" => array(
                    "blocked" => $abonement->blocked,
                    "block_start" => date_format( date_create($abonement->block_start), "Y-m-d"),
                    "block_end" => date_format( date_create($abonement->block_end), "Y-m-d")
                )
            ));


        }
    }


    public function getaudioblockAction(){

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $audiosession = Audiosession::getById($id);

            Document::sendAjaxResponse(array(
                "error" => false,
                "block" => array(
                    "blocked" => $audiosession->blocked,
                    "block_start" => date_format( date_create($audiosession->blockstart), "Y-m-d"),
                    "block_end" => date_format( date_create($audiosession->blockend), "Y-m-d"))
            ));
        }

        Document::sendAjaxResponse(array(
            "error" => true,
            "content" => "Для такого интервала аудиосессии не найдены"
        ));

    }

    public function sessionlistadminAction(){
        $list = Database::getDB()->get("audiosessions");
        $layout = getAudiosessionWindowListAdmin($list);
        Document::sendAjaxResponse(array(
            "error" => false,
            "list" => $layout
        ));


    }

}