<?php

/**
 * Класс для работы с Абонементами.
 *
 * Абонементы определяют порядок прослушивания аудиосеансов на сайте. У абонемента есть список сессий из 10 позиций
 *
 * started  -  когда абонемент начался, время начала первого сеанса = первого интервала
 * lastmodifed - последнее изменение абонемента,  если установлено, то это новый started
 * end - конец абонемента = конец последнего интервала в абонементе.
 * интервалы отсортированы при создании от первого ближайшего по времени, на момент создания

 */
class Abonement extends Storable
{
    /** @var int $id id абонемента */
    public $id = null;

    /** @var int $owner id пользователя, владельца абонемента */
    public $owner;

    /** @var string $asids
     * Тут хранится строка вида '1,3,4,6,1,2,3,0,0,0'.
     * Так обозначается план прослушиваний. Цифры - ID сеансов, 0 - сеанс отсутствует,
     * расположены в порядке прослушивания */
    public $asids = '';

    /** @var int $duration Длительность прослушивания, по прайсу */
    public $duration = 0;

    /** @var string $intervals JSON STRING Интервалы прослушиваний */
    public $intervals;

    /** @var int $times Количество прослушиваний в день, по прайсу */
    public $times = 0;

    /** @var int $paid Флаг указывает оплачен сеанс или нет */
    public $paid = 0;

    /** @var DateTime $created Дата создания сеанса */
    public $created;

    /** @var DateTime $started Дата начала прослушиваний, начало первого сеанса */
    public $started;

    /** @var float $outsum Это реальная стоимость сеанса, которую оплатил покупатель */
    public $outsum = null;

    public $code;

    /** @var int $blocked Заблокирован ли абонемент */
    public $blocked = 0;

    /** @var DateTime $block_start Время начала блокировки */
    public $block_start = null;

    /** @var DateTime $block_end Время конца блокировки  */
    public $block_end = null;


    /** @var DateTime $paytime Время когда была произведена оплата сеанса */
    public $paytime;

    /** @var DateTime $expired устанавливается во время создания сеанса.
    Указывает на дату, после которой он удаляется из базы,
    если не был оплачен. */
    public $expired;

    /** @var string $description Описание абонемента */
    public $description = "Без описания";

    /** @var DateTime $ending Когда оканчивается абонемент, время конца последнего сеанса. */
    public $ending = null;


    /**
     * Абонементы могут изменяться - изменяется порядок прослушивания сеансов.
     * При изменении, здесь указывается время следующего, еще не начавшегося интервала.
     *
     * @var DateTime $last_modifed Указывает на последнее изменение абонемента.
     */
    public $last_modifed = null;


    /**
     * Abonement constructor.
     * @param array $settings
     */
    public function __construct($settings = array())
    {
        parent::__construct($settings);
    }


    public static function validate($input)
    {
        if (!empty($input['duration'])) {
            $duration = intval($_REQUEST['duration']);
        }
        if (!empty($input['times'])) {
            $times = intval($input['times']);
        }
        $intervals = empty($_POST['interval']) ? array() : $_POST['interval'] ;

        $plan = array();
        if (!empty($input['listenplan'])) {
            $listenplan = $input['listenplan'];
            for ($i = 0; $i < 10; $i++) {
                $item = isset($listenplan[$i]) ? intval($listenplan[$i]) : 0 ;
                array_push($plan, $item);
            }
        }
        $plan = implode(",", $plan);

        $options = array(
            "intervals" => $intervals,
            "duration" => $duration,
            "times" => $times,
            "asids" => $plan
        );
        return $options;
    }


    public function getForm(){

        return array();

    }

    static function getTableData(){

        $query = "SELECT abonements.* , users.id as userid, abonements.id , users.firstname, users.lastname FROM abonements, users WHERE users.id=abonements.owner ";
        $results = Database::getDB()->getQuery($query);

        $rowData = array();

        foreach($results as $data){
            $abonement = new Abonement($data);
            $rowData[] = array(
                "abonement" => $abonement,
                "owner-name" => $data['firstname']." ".$data['lastname']
            );
        }

        return $rowData;

    }

    public function getPaidLabel(){
        if($this->paid) return "Да";
        return "Нет";
    }

    public function getEndDatetime(){
        $startDatetime = date_create($this->created);
        $date_interval = Abonement::getDateInterval($this->duration);
        $date_end = date_add($startDatetime, $date_interval);

        return $date_end;
    }

    public function getBlockStart($format = null){
        $datetime = date_create($this->block_start);
        if($format) return date_format($datetime, $format);
        return $datetime;
    }

    public function getBlockEnd($format = null){
        $datetime = date_create($this->block_end);
        if($format) return date_format($datetime, $format);
        return $datetime;
    }

    public function getAudiosessions(){
        return Audiosession::getAudiosessionsFromIDString($this->asids);
    }

    static function userCanCreateAbonement(){

        $user = User::getCurrentUser();

        if($user)
        {
            $abonement = Abonement::getByOwner($user->id, 1);

            if(!$abonement)  return true;
        }

        return false;
    }

    static function getAll(){
        self::delExpired();
        return parent::getAll(__CLASS__);
    }

    static function getById($id){
        self::delExpired();
        return parent::getById(__CLASS__, $id);
    }

    /**
     * Возвращает историю изменений абонемента
     *
     * @param null $id
     * @return bool|mixed
     */
    public function getHistory($id = null){

        if($id == null) $id = $this->id;

        $query = "SELECT history FROM abonements WHERE id=$id";
        if($result = Database::getDB()->getQuery($query) ){
            if(count($result))
                return json_decode($result[0]['history'], true);
        }
        return false;
    }

    /**
     * Сохраняет историю изменений абонемента
     *
     * @param $history
     * @param null $id
     * @return mixed
     */
    public function saveHistory($history, $id = null){

        if($id == null) $id = $this->id;

        $db = Database::getDB();
        $data = json_encode($history);
        $data = $db->escape($data);
        $query = "UPDATE abonements SET history='$data' WHERE id=$id";
        return $db->setQuery($query);
    }


    /**
     * Возвращает интервалы в виде массива часов начала сеансов
     *
     * @return mixed
     */
    public function getIntervals()
    {
        return json_decode($this->intervals);
    }

    /**
     * Сохраняет интервалы в виде строки json
     *
     * @param $intervals
     */
    public function setIntervals($intervals)
    {
        $this->intervals = json_encode($intervals);
    }



    /**
     * Возвращает имя таблицы в базе данных
     *
     * @return string
     */
    static function tableName(){
        return "abonements";
    }


    /**
     *  Удаляет из базы просроченные абонементы
     */
    static function delExpired(){
        Database::getDB()->del("abonements", "paid=0 and expired < NOW()");
    }


    /**
     * Удаляет абонемент из базы данных
     *
     * @param $id
     * @return bool
     */
    static function delete($id){
        return Database::getDB()->del("abonements", "id=$id");
    }

    /**
     * Сохраняет абонемент в базе данных
     *
     * @return bool
     */
    public function save(){
        
        $data = array(
            "owner" => $this->owner,
            "asids" => Format::quote($this->asids),
            "duration" => Format::quote($this->duration),
            "description" => Format::quote($this->description),
            "times" => $this->times,
            "blocked" => $this->blocked,
            "paid" => $this->paid,
            "paytime" => Format::quote($this->paytime)
        );
        
        if($this->outsum)       $data['outsum']      = $this->outsum;
        if($this->created)      $data['created']     = Format::quote($this->created);
        if($this->block_start)  $data['block_start'] = Format::quote($this->block_start);
        if($this->block_end)    $data['block_end']   = Format::quote($this->block_end);
        if($this->expired)      $data['expired']     = Format::quote($this->expired);
        if($this->intervals)    $data['intervals']   = Format::quote(Database::getDB()->escape($this->intervals));
        if($this->last_modifed) $data['last_modifed']= Format::quote($this->last_modifed);
        if($this->started)      $data['started']     = Format::quote($this->started);
        if($this->ending)       $data['ending']      = Format::quote($this->ending);

        // $plan=array();
        // $asidsArray=explode(',',$this->asids);
        // $duration= getDurationTimeOfDays($data['duration']);
        // $indexAsids=0;
        // for($i=0; $i<$duration; $i++){

        //     for($j=0; $j<$data['times']; $j++){
        //         if(count($asidsArray)>=$indexAsids){
        //             $indexAsids=0;
        //         }
        //         $date=($this->last_modifed=="") ? $this->started->format('Y-m-d H:i:s') : $this->started->format('Y-m-d')." ".$this->last_modifed->format('H:i:s');

        //         $plan["$date"]=$asidsArray[$indexAsids];

        //     }
        
        // }


        // Если абонемент только что создан
        if($this->id == null){

            $names = implode(',', array_keys($data));
            $values = implode(',', array_values($data));

            $query = "INSERT INTO abonements ($names) VALUES ($values) ";
        } else {

            $id = $this->id;

            $names_values_array = array();

            foreach ($data as $key => $value){
                array_push($names_values_array, $key."=".$value);
            }

            $names_values_string = implode(",", $names_values_array);

            $query = "UPDATE abonements SET $names_values_string WHERE id=$id";
        }

        if(!$result = Database::getDB()->setQuery($query))
            return false;

        if($this->id == null)
            $this->id = Database::getDB()->getLastId();
        return true;
    }


    /**
     * Возвращает абонемент из базы по его владельцу.
     * В процессе удаляет устаревшие абонементы.
     *
     * @param $id
     * @param null $paid
     * @return Abonement|null
     */
    static function getByOwner($id, $paid = null){

        if($paid === 1 || $paid === 0){
            $paid = " and paid=".$paid;
        } else $paid = '';

        Abonement::delExpired();
        $abonement = Database::getDB()->getOne("abonements", "owner=$id".$paid);
        if( !empty($abonement) )
            return new Abonement($abonement);
        return null;
    }


    /**
     * Возвращает дату начала первого интервала после изменения, или с начала абонемента
     *
     * @return DateTime
     */
    public function getStart($realStart = false)
    {
        if($this->last_modifed !== null && !$realStart)
            $start = $this->last_modifed;
        else
            $start =  $this->started;

        return new DateTime($start);

    }

    /**
     * Возвращает дату конца последнего интервала
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return new DateTime($this->ending);
    }

    // Функции ссылающиеся на Price и Intervals
    public function getTimesTotal()
    {
        $in = new Intervals($this);
        return $in->getTimesTotal();
    }
    public function getLeftSum()
    {
        $p = new Price();
        return $p->getLeftSum($this);
    }
    public function getTimesLeft()
    {
        $in = new Intervals($this);
        return $in->getTimesLeft();
    }

    /**
     * Возвращает оставшееся время действия абонемента, с текущего момента
     *
     * @param string $format
     * @return DateInterval|false|string
     */
    public function getLeftDuration($format = null){
        $now = date_create();
        $end = $this->abonement->getEnd();
        $diff = date_diff($end , $now);
        if($format) return date_format($diff, $format);
        return $diff;
    }


    /**
     * Возвращает план прослушивания
     *
     * в виде:
     * array = [0] => {Audiosession},
     *         [1] => {Audiosession},
     *         [2] => 0,
     *         [.] => 0,
     *          ...
     *         [9] => {Audiosession}
     *
     * @return array
     */
    public function getPlanList($asids = null)
    {
        if($asids === null) $asids = $this->asids;
        $audiosessions = Audiosession::getAudiosessionsFromIDString($asids);
        $indexedAudiosessions = indexedIDArray($audiosessions);

        $plan = explode(',',$asids);

        foreach($plan as $key => &$value) {
            if(!empty($value)) $value = $indexedAudiosessions[$value];
        }

        $newArray=array();
        for($i=0; $i<count($plan); $i++){

            if(!empty($plan[$i])){

                $newArray[]=$plan[$i];
            }
        }

        return $newArray;
    }

    /**
     * Возвращает "План прослушивания"
     *
     * @return array
     */
    public function getCurrentPlan()
    {
        $startDate = $this->getStart(true);
        $currentTime = date_create();
        $currentHours = $currentTime->format('H:i');
        
        $asidsArray=$this->getPlanList();

        $lastDays=$startDate->diff($currentTime);

        $audiosessionsCount = count($asidsArray);

        if($lastDays->d*$this->times<$audiosessionsCount){
            $indexAsids=$lastDays->d*$this->times;
        }
        else{
            $indexAsids=($lastDays->d *$this->times) % $audiosessionsCount;
        }

        $currentHours=str_replace(':','.',$currentHours);
        $intervalsArray= json_decode($this->intervals);
        $indexInterval=0;

        for($i=0; $i<count($intervalsArray); $i++){

            if($intervalsArray[$i]+3<$currentHours){
                $indexAsids+=1;
                $indexInterval+=1;
            }
        }

        
        $plan = array();
        $daysInterval=0;
        for($i=0; $i<count($asidsArray); $i++){

            if($indexInterval >= count($intervalsArray)){
                $indexInterval = 0;
                $daysInterval+=1;
            }
            
            // если мы уже конце массива нужно обратно с первого элемента нужно начинат
            if($indexAsids>=count($asidsArray)){
                $indexAsids=0;
            }
            $plan[$i]['index']=$asidsArray[$indexAsids];
            $plan[$i]['time']=Intervals::getHourBeforeEnd($intervalsArray[$indexInterval]+3,$daysInterval);
            $indexInterval++;
            $indexAsids++;

        }


        // var_dump($plan);




        // $startDate = $this->getStart();
        // $currentTime = date_create();
        // $plan = $this->getPlanList();
        // var_dump($plan);

        // $plan = clearSavingOrder($plan);
        // var_dump($plan);
        
        /**
         * $plan=array(
         *      array(
         *          [0] => {Audiosession},
         *           order=> 0
         *      ),
         *      array(
         *          [1] => {Audiosession},
         *          order=> 1
         *      )
         * ); 
         */

        // $audiosessionsCount = count($plan);

        // $IntervalsObject = new Intervals($this);
        // $timesCount = $IntervalsObject->getTimesCount(null, $startDate, $currentTime);

        // Вычисляем индекс интервала, который соответствует первому сеансу
        // $temp = $timesCount / $audiosessionsCount;
        // $ost = $timesCount % $audiosessionsCount;
        // $completePlans = floor($temp);
        // $planIndexStart = $completePlans * $audiosessionsCount;

        // for($i = 0; $i < $audiosessionsCount; $i++)
        // {
        //     $index = $planIndexStart + $i;

        //     if($i < $ost)
        //         $index += $audiosessionsCount;

        //     $plan[$i]['index'] = $index;
        //     $plan[$i]['time'] = $IntervalsObject->getTimeByIndex(null, $index, $startDate);
        // }

        // $plan = restoreOrder($plan);


        $plan=$this->sortPlanByDate($plan);

        /** @var array $plan */
        return $plan;
    }





    /**
     * Возвращает плеер для текущего аудиосеанса
     *
     * @return null|string
     */
    public function getPlayer()
    {
        if($this->canListenNow())
        {
            if($audiosession = $this->getCurrentAudiosession())
            {
                $player = new Player($audiosession);
                return $player->render();
            }
        }
        return null;
    }

    /**
     * Возвращает аудиосессию, которая доступна в данный момент для прослушивания
     *
     * @return Audiosession|null
     */
    public function getCurrentAudiosession()
    {
        $plan = $this->getCurrentPlan();

        foreach($plan as $session)
        {
            if( Intervals::isNow($session['time']) ) {
                return Audiosession::getById($session[0]['id']);
            }
        }

        return null;
    }

    public function canListenNow()
    {
        if($this->getCurrentAudiosession())
            return true;

        return false;
    }



    /* автор Нурсултан */

    /**
     * Функция возвращает сортированный план(массив) по дате
     * @param  array()
     * return  array() 
     */
    function sortPlanByDate($plan){
        
        for($i=0; $i<count($plan); $i++){

            for($j=0; $j<count($plan)-1; $j++){

                if(dateTimeCmp($plan[$j]['time'],$plan[$j+1]['time'])==-1){

                    $tmp=$plan[$j]['time'];
                    $plan[$j]['time']=$plan[$j+1]['time'];
                    $plan[$j+1]['time']=$tmp;
                }
            }
            
        }
        
        return $plan;
    }


}


