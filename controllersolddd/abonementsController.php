<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 1:35
 */

class abonementsController extends Controller
{


    function defaultAction()
    {
        if (defined("ADMIN") )/* && $user = Authorization::mustHaveAdminAccess()) */ {

            Abonement::delExpired();
            $tableData = Abonement::getTableData();
            return Document::getTemplate("abonements", $tableData);
        } else {
            return $this->viewAction();
        }
    }


    function viewadminAction(){

        User::can('review_statistics') or die("вы не можете просматривать статистику абонементов");

        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);

            /** @var Abonement $abonement */
            $abonement = Abonement::getById($id);

            $sessionsPlan = $abonement->getPlanList();

            return Document::getTemplate("abonement", array(
                "abonement" => $abonement,
                "audiosessionsPlan" => $sessionsPlan
            ));
        }


    }


    function deleteAction()
    {

        User::can('delete_abonements') or die("вы не можете удалять абонементы");

        if (!empty($_REQUEST['id'])) {

            $id = intval($_REQUEST['id']);

            Abonement::delete($id);

            return $this->defaultAction();
        }
    }


    public function createAction()
    {

        $price = new Price();
        $priceTable = $price->getPriceRows();

        $table = Document::getTemplate("price-count-table", $priceTable);

        return Document::getTemplate("create_abonement", array(
            "price-table" => $table,
        ));

    }


    public function viewAction(){

        $user = User::getCurrentUser();

        if($user){

            $abonement = Abonement::getByOwner($user->id);

            if($abonement) {

                $plan = $abonement->getCurrentPlan();

                //if(isset($_GET['listening']) && $_GET['listening'] === true)
                    $player = $abonement->getPlayer();
                //else
                    //$player = '';

                return Document::getTemplate("my_abonements", array(
                    "plan" => $plan,
                    "abonement" => $abonement,
                    "player" => $player
                ));
            }

        }

        return Document::getTemplate("404", array());
    }


    public function listenAction(){

        $user = User::getCurrentUser();

        if($user){

            $abonement = Abonement::getByOwner($user->id);

            if($abonement) {

                $audiosessionsData = Audiosession::getAudiosessionsFromIDString($abonement->asids);

                $abonementObj = new Abonement($abonement);

                foreach($audiosessionsData as &$session){
                    $session['can_listen'] = $abonementObj->canListenNow($session);
                }

                $datetime_start = date_create($abonement['created']);
                $start =  date_format($datetime_start, "d.m.y");
                $dateInterval = Abonement::getDateInterval($abonement['duration']);
                $datetime_end = date_add($datetime_start, $dateInterval);
                $end = date_format($datetime_end, "d.m.y");

                $player = $abonementObj->getPlayer();

                return Document::getTemplate("my_abonements", array(
                    "audiosessions" => $audiosessionsData,
                    "abonement" => $abonement,
                    "start-date" => $start,
                    "end-date" => $end,
                    "player" => $player
                ));
            }

        }

        return Document::getTemplate("404", array());



    }



    public function historyAction(){

        if(!empty($_REQUEST['id'])){

            $id = intval($_REQUEST['id']);

            $abonement = Abonement::getById($id);
            $audiosessions = Audiosession::getAudiosessionsFromIDString($abonement->asids);
            $history = Abonement::getHistory($abonement->id);

            return Document::getTemplate("abonement-history", array(
                "history" => $history,
                "audiosessions" => $audiosessions,
                "abonement" => $abonement
            ));
        }

        return Document::getTemplate("404", array());

    }


    public function saveblockAction(){

        User::can('block_abonements') or die("вы не можете изменять блокировки абонемента");

        if(!(empty($_REQUEST['id']) || empty($_REQUEST['start_date']) || empty($_REQUEST['end_date'])) ){

            $id = intval($_REQUEST['id']);
            $start_date = date_create($_REQUEST['start_date']);
            $end_date = date_create($_REQUEST['end_date']);
            $cur_date = date_create();

            if($start_date < $end_date && $cur_date < $end_date) {

                $abonement = Abonement::getById($id);

                $abonement->blocked = 1;
                $abonement->block_start = date_format($start_date, "Y-m-d H:i:s");
                $abonement->block_end = date_format($end_date, "Y-m-d H:i:s");

                $abonement->save();
            }
        }
        return $this->defaultAction();
    }


    public function changelistAction(){

        if(!empty($_REQUEST['id']) && !empty($_REQUEST['asess'])){

            $id = intval($_REQUEST['id']);

            $asses = $_REQUEST['asess'];

            $ass = array();
            foreach($asses as &$as){
                $as = intval($as);
                $ass[] = $as;
            }

            $asids = implode(',', $ass);

            $abonement = Abonement::getById($id);
            $abonement->asids = $asids;
            $abonement->save();

            $historyItem = createHistoryItem($asids);

            $history = Abonement::getHistory($id);

            if(empty($history)) $history = array();

            $history[] = $historyItem;

            Abonement::saveHistory($id, $history);
        }

        return $this->defaultAction();


    }


    public function freeblockAction(){
        if(!empty($_REQUEST['id'])){


            $id = intval($_REQUEST['id']);

            $abonement = Abonement::getById($id);
            $abonement->blocked = 0;
            $abonement->block_start = null;
            $abonement->block_end = null;
            $abonement->save();

            return $this->defaultAction();

        }
    }


    public function paymentsuccessAction(){
        requestlog();
        return Document::getTemplate("success");
    }


    public function paymentfailAction(){
        requestlog();
        return Document::getTemplate("fail");
    }


    public function paymentAction()
    {
        global $config;

        requestlog();

        if (!empty($_REQUEST['OutSum']) &&
            !empty($_REQUEST['InvId']) &&
            !empty($_REQUEST['SignatureValue'])
        ) {
            $mrh_pass2 = $config['payment']['password2test'];

            // чтение параметров

            $out_summ = $_REQUEST["OutSum"];
            $inv_id = $_REQUEST["InvId"];
            $crc = $_REQUEST["SignatureValue"];

            $crc = strtoupper($crc);


            $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));

            mylog(array(
                "crc" => $crc,
                "my_crc" => $my_crc,
                "post" => $_POST
            ));

            if ($my_crc == $crc) // если подписи совпадают
                if ($abonement = Abonement::getById($inv_id)) // если абонемент существует
                    if ($abonement->paid == 0) // если абонемент еще не оплачен
                    {
                        mylog("Оплата прошла через проверки:  если подписи совпадают, если абонемент существует если, абонемент еще не оплачен");
                        $abonement->paytime = date_format(date_create(), "Y-m-d H:i:s");
                        mylog($abonement->paytime);
                        $abonement->paid = 1;

                        $res = $abonement->save();

                        mylog($res);

                        // признак успешно проведенной операции
                        Document::sendResponse("OK$inv_id\n");

                    }
        }

        Document::sendResponse("bad sign\n");
    }


    function changeAction(){

        if($user = User::getCurrentUser()){

            if($abonement = Abonement::getByOwner($user->id)) {

                return Document::getTemplate("change_abonement", array("abonement" => $abonement ));
            }
        }
        return $this->viewAction();
    }


    function savechangesAction(){
        if(!empty($_POST['id'])){
            $id = intval($_POST['id']);

            $intervals = empty($_POST['interval']) ? array() : $_POST['interval'];

            $plan = array();
            if (!empty($_POST['listenplan'])) {
                $listenplan = $_POST['listenplan'];
                for ($i = 0; $i < 10; $i++) {
                    $item = intval($listenplan[$i]);
                    array_push($plan, $item);
                }
            }
            $plan = implode(",", $plan);



            if($user = User::getCurrentUser()){

                if($abonement = Abonement::getById($id)){

                    if($abonement->owner == $user->id){

                        $abonement->intervals = json_encode($intervals);
                        $abonement->asids = $plan;

                        if($abonement->save()){


                            $historyItem = createHistoryItem($plan);

                            $history = Abonement::getHistory($abonement->id);

                            if(empty($history)) $history = array();

                            $history[] = $historyItem;

                            Abonement::saveHistory($history, $abonement->id);

                            return $this->viewAction();
                        }

                    }

                }

            }
        }
    }


    function getshedulefileAction(){

        $user = User::getCurrentUser();

        if(!$abonement = Abonement::getByOwner($user->id)) exit();

        $shedule = Intervals::getSheduleList($abonement);
        createSheduleXSLFile($shedule);
        exit;
    }


    function getfilehistoryAction(){

        if(!empty($_REQUEST['id'])){
            $id = intval($_REQUEST['id']);

            if($abonement = Abonement::getById($id)){
                $history = Abonement::getHistory($abonement->id);
                createHistoryXSLFile($history);
            }
        }
        exit;
    }

}