<?php
// Запрещает прямой запуск в обход index.php
defined('BEZNEVROZA') or die("Доступ запрещен...");

function __autoload($classname){
    $filename = PATH_INCLUDES.DS."classes".DS.$classname.".php";
    include_once $filename;
}


function processRequest(){

    global $config;

    $action_label = $config['action-label'];
    $controller_label = $config['controller-label'];
    $controllers = $config['controllers'];

    if( !empty( $_GET[$controller_label] ) && isset( $controllers[$_GET[$controller_label]] ) ) {
        $controller_name = $controllers[ $_GET[$controller_label] ];
    } else {
        $controller_name = $config['default-controller'];
    }

    $controller_file = HOME_DIR.DS."controllers".DS.$controller_name.".php";

    if(file_exists($controller_file)) {
        include_once $controller_file;
    } else {
        die("error: wrong controller");
    }


    /** @var Controller $controller */
    $controller = new $controller_name();

    if( !empty($_GET[$action_label]) ){
        $action = $_GET[$action_label];
    } else {
        $action = "default";
    }

    // var_dump($controller);
    // var_dump($action);

    if( $controller->haveAction($action) ) {
        $actionName = $action . "Action";
        
        return $controller->$actionName();
    }
    else
        return $controller->defaultAction();
}




function getHeader(){
    $user = User::getCurrentUser();
    return Document::getTemplate('header', array('user' => $user));
}
function getFooter(){
    return Document::getTemplate('footer');
}



function error($text = ''){
    global $document;
    $document->displayError($text);
}

/*
function redirect($action){
    global $controllers;
    $controllers[$action]();
}
*/



function getCardThumbnail($audiosession){
    echo Document::getTemplate ('thumbnail_card', $audiosession);
}


function getActionLink($controller, $action = "default", $additional_params = array()){

    global $config;

    if(!array_key_exists($controller, $config['controllers'])) return "wrong-controller";

    $ctrl_label = $config['controller-label'];
    $act_label = $config['action-label'];

    $params = array(
        $ctrl_label => $controller,
        $act_label => $action
    );

    $params = array_merge($params, $additional_params);

    $url_params = array();
    foreach($params as $key => $value){
        $url_params[] = $key."=".$value;
    }
    $link = "index.php?".implode("&",$url_params);

    return $link;
}

function createHistoryItem($asids){

    $today = date_format(date_create(), "d.m.Y");

    $temp = new Abonement();
    $sessionPlan = $temp->getPlanList($asids);

    $listdata = array();
    for( $i = 0 ; $i < 10; $i++ ){
        if($sessionPlan[$i]){
            $listdata[$i] = array(
                "id" => $sessionPlan[$i]['id'],
                "caption" => $sessionPlan[$i]['caption']
            );
        }
    }

    $historyItem = array(
        "modifed" => $today,
        "asids"=> $asids,
        "audiosessions" => $listdata
    );

    return $historyItem;
}



function getAssetsUrl(){
    return Document::getAssetsLocation();
}


function getAdminLeftMenu(){
    //echo Document::getTemplate("admin-left-menu");
    return "";
}

function getMedia($relativeUrl){
    if(defined("ADMIN"))
        return "../media/".$relativeUrl;
    else
        return "media/".$relativeUrl;
}


function getMounth($n){
    $mounts = array(
        1 => "Январь",
        2 => "Февраль",
        3 => "Март",
        4 => "Апрель",
        5 => "Май",
        6 => "Июнь",
        7 => "Июль",
        8 => "Август",
        9 => "Сентябрь",
        10 => "Октябрь",
        11 => "Ноябрь",
        12 => "Декабрь"
    );

    return $mounts[$n];



}

function getUserBlocks($id){

    $blocks = Database::getDB()->get("blocks", "user_id=$id");
    return $blocks;

}

function getBlockWindowContent($id){
    $blocks = getUserBlocks($id);

    $rights = Role::getRightsList();

    $allRightsBlocks = array();
    foreach($rights as $key => $val){

        $allRightsBlocks[$key] = false;

        foreach($blocks as $block){
            if($block['law_name'] == $key){
                $allRightsBlocks[$key] = $block['end'];
            }
        }
    }

    return Document::getTemplate("blocks-window", array(
        "blocks" => $allRightsBlocks,
        "userid" => $id
    ));

}

function getBlocksSelectField($name){
    return "<select name=\"$name\" class=\"form-control\">
                    <option value=\"0\" selected>нет блокировки</option>
                    <option value=\"1\">1 дн.</option>
                    <option value=\"2\">1 нед.</option>
                    <option value=\"3\">1 мес.</option>
                    <option value=\"4\">3 мес.</option>
                    <option value=\"5\">6 мес.</option>
                    <option value=\"6\">навсегда</option>
                </select>";
}

function getBlockField($blocks, $name){

    echo "<td>";

    if($blocks[$name])
        echo "<span>Закончится:<br>".$blocks[$name]."</span> <input type=\"hidden\" name=\"$name\" value=\"".$blocks[$name]."\">";
    else {
        if($blocks[$name] === null) echo "<span>Заблокирован:<br>навсегда</span><input type=\"hidden\" name=\"$name\" value=\"6\">";
        else
            echo getBlocksSelectField($name);
    }

    echo "</td><td>";

    if($blocks[$name] !== false)
        echo "<div class=\"delete-block-btn\" onclick=\"deleteblock(this,'$name')\"></div>";

    echo "</td>";
}


function saveBlocksArray($blocks){

    $userid = $blocks['id'];

    unset($blocks['id']);

    $values = array();
    foreach ($blocks as $key => $value) {

        switch ($value){
            case "0":   // не заблокирован
                $end = 0;
                break;
            case "1":   // 1 день
                $end = "ADDDATE(NOW(), INTERVAL 1 DAY)";
                break;
            case "2":   // 1 неделя
                $end = "ADDDATE(NOW(), INTERVAL 1 WEEK)";
                break;
            case "3":   // 1 месяц
                $end = "ADDDATE(NOW(), INTERVAL 1 MONTH)";
                break;
            case "4":   // 3 месяца
                $end = "ADDDATE(NOW(), INTERVAL 3 MONTH)";
                break;
            case "5":   // 6 месяцев
                $end = "ADDDATE(NOW(), INTERVAL 6 MONTH)";
                break;
            case "6":   // навсегда
                $end = "null";
                break;
            default:
                $end = "'".$value."'";

        }
        if($end !== 0) $values[] = "($userid, '$key' , $end)";
    }

    $query  = "DELETE FROM blocks WHERE user_id=$userid; ";
    $res = Database::getDB()->setQuery($query);

    if(!empty($values)){
        $query = "INSERT INTO blocks (`user_id`, `law_name`, `end`) VALUES ";
        $query .= implode(",",$values);
        $res = Database::getDB()->setQuery($query);
    }

    return $res;

}
function getAudiosessionAdminWindowList($list){

    $content = "<ul>";
    foreach($list as $as){
        $imgLink = getMedia($as['img']);
        $content .= "<li onclick=\"selectSession({$as['id']})\">

                        <img src=\"$imgLink\" alt=\"\">
                        <span>{$as['caption']}</span>

                    </li>";
    }
    $content .= "</ul>";

    return $content;

}

function getAudiosessionWindowList($list){




    $content = "<ul>";
    foreach($list as $as){
        $imgLink = getMedia($as['img']);
        $content .= "<li onclick=\"selectSession({$as['id']})\">

                        <img src=\"$imgLink\" alt=\"\">
                        <span>{$as['caption']}</span>

                    </li>";
    }
    $content .= "</ul>";

    return $content;

}


function getDetailsWindowContent($as){

return "<div class=\"image-side\">
                    <img src=\"".getMedia($as->img)."\" alt=\"\">
                    <div class=\"clearfix\">
                        <div class=\"btn btn-primary\" data-session='{$as->id}'>Выбрать</div>
                        <div class=\"btn btn-success\" onclick='backToList()' >К списку</div>
                    </div>
                </div>
                <div class=\"desc-side\">
                    <h3>{$as->caption}</h3>
                    <p><b>Описание:</b>{$as->description}</p>
                </div>";




}



function getSheduleListBlock($shedule){

    $content = "<table class=\"admin-table abonements-shedule-table\">
        <tr>
            <th>Дата</th>
            <th>Время</th>
            <th>Название</th>
        </tr>";

    foreach($shedule as $item){

        $datetime = $item['datetime'];
        $date = date_format($datetime, "d.m.y");
        $time = date_format($datetime, "H:i");
        $datetime = date_modify($datetime, "+3 hour");
        $time_ending = date_format($datetime, "H:i");
        $caption = $item['asess']['caption'];

        $content .= "
        <tr>
            <td>$date</td>
            <td>$time - $time_ending</td>
            <td>$caption</td>
        </tr>";
    }
    $content .= "</table>";

    return $content;

}



function getAudiosessionWindowListAdmin($list){

    $content = "<ul>";
    foreach($list as $as){
        $imgUrl = getMedia($as['img']);
        $content .= "<li onclick=\"selectSessionAdmin({$as['id']}, '{$as['caption']}')\">

                        <img src=\"$imgUrl\" alt=\"\">
                        <span>{$as['caption']}</span>

                    </li>";
    }
    $content .= "</ul>";

    return $content;

}

function redirect($controller = "", $action = ""){

    global $config;

    $clabel = $config['controller-label'];
    $alabel = $config['action-label'];

    $_GET[$clabel] = $controller;
    $_GET[$alabel] = $action;

    return processRequest();
}

function requestlog(){
    ob_start();
    echo "Запрос: ".date_format(date_create(), "Y-m-d H:i:s")."\n";
    var_dump($_REQUEST);
    $output = ob_get_contents();
    ob_end_clean();
    file_put_contents("log.txt", $output."\n\n", FILE_APPEND);


}

function mylog($var){
    ob_start();
    echo var_dump($var);
    $output = ob_get_contents();
    ob_end_clean();
    file_put_contents("log.txt", $output."\n", FILE_APPEND);
}


function checkBlocks($user, $right){


    if($user->blocks === null){

        $user->blocks = array();

        $result = Database::getDB()->get("blocks", "user_id=".$user->id);

        $expired_blocks = array();

        foreach($result as $block){

            $current_date = date_create();
            if(!empty($block['end'])) $block_end_date = date_create($block['end']);
            $block_start_date = date_create($block['start']);

            if(!empty($block['end'])) $v = $current_date > $block_end_date;
            else $v = false;
            $g = $block_start_date > $current_date;

            if($v || $g){
                $expired_blocks[] = $block['id'];
            } else {
                $user->blocks[$block['law_name']] = 1;
            }
        }

        if(!empty($expired_blocks)){
            $expired_blocks_string = implode(",", $expired_blocks);
            $query = "DELETE FROM blocks WHERE id IN($expired_blocks_string)";
            if(!Database::getDB()->setQuery($query))
                die("database error");
        }
    }

    if(isset($user->blocks[$right])) {
        return $user->blocks[$right];
    }

    return false;

}


function getEmailTemplate($data){
    return Document::getTemplate("mail_layout", $data);
}



function createSheduleXSLFile($shedule = array()){

    require_once(PATH_INCLUDES.DS.'libraries'.DS.'PHPExcel.php');
    require_once(PATH_INCLUDES.DS.'libraries'.DS.'PHPExcel/Writer/Excel5.php');

    // Создаем объект класса PHPExcel
    $xls = new PHPExcel();
// Устанавливаем индекс активного листа
    $xls->setActiveSheetIndex(0);
// Получаем активный лист
    $sheet = $xls->getActiveSheet();
// Подписываем лист
    $sheet->setTitle('Расписание абонемента');

// Вставляем текст в ячейку A1
    $sheet->setCellValue("A1", 'Расписание аудиосеансов');
    $sheet->getStyle('A1')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID);
    $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');
    $sheet->getColumnDimension('C')->setWidth(100);

// Объединяем ячейки
    $sheet->mergeCells('A1:C1');

// Выравнивание текста
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $row = 3;

    $sheet->setCellValueByColumnAndRow(0,2, "Дата");
    $sheet->getStyleByColumnAndRow(0, 2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow(1,2, "Время");
    $sheet->getStyleByColumnAndRow(1, 2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow(2,2, "Название аудиосеанса");
    $sheet->getStyleByColumnAndRow(2, 2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    foreach($shedule as $item){
        $sheet->setCellValueByColumnAndRow(0,$row, date_format($item['datetime'], "d.m.y"));
        $sheet->getStyleByColumnAndRow(0, $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(1,$row, date_format($item['datetime'], "H:i"));
        $sheet->getStyleByColumnAndRow(1, $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(2,$row, $item['asess']['caption']);
        $sheet->getStyleByColumnAndRow(2, $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $row++;
    }

    // Выводим HTTP-заголовки
    header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
    header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
    header ( "Cache-Control: no-cache, must-revalidate" );
    header ( "Pragma: no-cache" );
    header ( "Content-type: application/vnd.ms-excel" );
    header ( "Content-Disposition: attachment; filename=matrix.xls" );

// Выводим содержимое файла
    $objWriter = new PHPExcel_Writer_Excel5($xls);
    $objWriter->save('php://output');
}


function createHistoryXSLFile($history = array()){

    require_once(PATH_INCLUDES.DS.'libraries'.DS.'PHPExcel.php');
    require_once(PATH_INCLUDES.DS.'libraries'.DS.'PHPExcel/Writer/Excel5.php');

    // Создаем объект класса PHPExcel
    $xls = new PHPExcel();
// Устанавливаем индекс активного листа
    $xls->setActiveSheetIndex(0);
// Получаем активный лист
    $sheet = $xls->getActiveSheet();
// Подписываем лист
    $sheet->setTitle('История изменений абонемента');

// Вставляем текст в ячейку A1
    $sheet->setCellValue("A1", 'История изменений');
    $sheet->getStyle('A1')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID);
    $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');
    $sheet->getColumnDimension('C')->setWidth(100);

// Объединяем ячейки
    $sheet->mergeCells('A1:B1');

// Выравнивание текста
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(100);
    $row = 2;

    foreach($history as $item){

        $sheet->mergeCells('A'.$row.':B'.$row);
        $sheet->setCellValueByColumnAndRow(0,$row , "Изменено ".date_format(date_create($item['modifed']),"d.m.Y"));
        $sheet->getStyleByColumnAndRow(0, $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        for($d = 0; $d<10; $d++){
            $caption = "";
            if(isset($item['audiosessions'][$d])) $caption = $item['audiosessions'][$d]['caption'];

            $sheet->setCellValueByColumnAndRow(0, $d + $row + 1, $d + 1);
            $sheet->getStyleByColumnAndRow(0, $d + $row + 1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValueByColumnAndRow(1,$d + $row + 1, $caption);
            $sheet->getStyleByColumnAndRow(1, $d + $row + 1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        }
        $row += $d + 1;
    }

    // Выводим HTTP-заголовки
    header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
    header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
    header ( "Cache-Control: no-cache, must-revalidate" );
    header ( "Pragma: no-cache" );
    header ( "Content-type: application/vnd.ms-excel" );
    header ( "Content-Disposition: attachment; filename=matrix.xls" );

// Выводим содержимое файла
    $objWriter = new PHPExcel_Writer_Excel5($xls);
    $objWriter->save('php://output');
}

function getRestoreEmailTemplate($data){
    return Document::getTemplate("remind", $data);
}

function getIntervalsModalWindow(){
    return Document::getTemplate("intervals_modal_window", null, 'client');
}

/**
 * преобразует массив , содержащий объекты(в виде массива) с полем id, в массив,
 * где ключи - значения id объектов
 *
 * @param $array
 * @return array
 */
function indexedIDArray($array)
{
    $indexed = array();
    foreach ($array as $item)
    {
        $indexed[ $item['id'] ] = $item;
    }

    return $indexed;
}

function clearSavingOrder($array)
{
    $new_array = array();
    $count = count($array);

    for($i = 0; $i < $count; $i++) {

        if(!empty($array[$i])){
            $new_array[] = array(
                $array[$i],
                'order' => $i
            );
        }
    }
    return $new_array;
}

function restoreOrder($array)
{
    $ordered = array();

    foreach($array as $item)
    {
        $ordered[ $item['order'] ] = $item;
    }

    return $ordered;
}



function intervalLablel($hour)
{
    $start = $hour;
    $end = $hour + 3;
    if($end >= 24) $end -= 24;

    return $hour.':00 - '.$end.':00';
}


function getQuestionCategories()
{
    $query = "SELECT * FROM question_category";

    $result = Database::getDB()->getQuery($query);
    return $result;
}


/* автор Нурсултан */

/**
 * функции для сравнения двух даты
 * @param  DateTime
 * @param DateTime
 * return если равны 0, если первый > второго -1, если первый < второго 1
 */

function dateTimeCmp($a, $b) 
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

