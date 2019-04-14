<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 12.07.2017
 * Time: 21:10
 */
class financesController extends Controller
{

    public function defaultAction(){

        $page = empty($_GET['page']) ? '' : intval($_GET['page']) ;
        $limit = 15;

        $transactions = Transactions::getTransactions($limit, $page);
        return Document::getTemplate('finances', array( 'transactions' => $transactions ));

    }
    	
    public function getdateAction(){
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
        /*if (isset($start_time, $end_time)) {
        	
        } else {
        	
        };*/
        $trans_d = Transactions::getTransactionsForDate($start_time, $end_time);
        

        return Document::getTemplate('finances', array( 'transactions' => $trans_d ));

    }

    public function getdatenowAction(){
        $start_time = date("Y-m-d");
        $end_time = $start_time;
        /*if (isset($start_time, $end_time)) {
            
        } else {
            
        };*/
        $trans_d = Transactions::getTransactionsForDate($start_time, $end_time);
        

        return Document::getTemplate('finances', array( 'transactions' => $trans_d, 'time' => $end_time ));

    }

    public function getdateweekAction(){
        $start_time = date ("Y-m-d", time() - (      date("N")-1) * 24*60*60);
        $end_time = date ("Y-m-d", time() - ( -6 + date("N")-1) * 24*60*60);

        $trans_d = Transactions::getTransactionsForDate($start_time, $end_time);
        

        return Document::getTemplate('finances', array( 'transactions' => $trans_d, 'time' => $start_time ));

    }
	

    public function getdatemonthAction(){
        $start_time = date ("Y-m-1");
        $end_time = date ("Y-m-t");

        $trans_d = Transactions::getTransactionsForDate($start_time, $end_time);
        

        return Document::getTemplate('finances', array( 'transactions' => $trans_d, 'time' => $end_time  ));

    }

}
?>