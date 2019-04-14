<?php

/**
 * Вспомогательный класс для абонементов, содержит всю логику рассчета интервалов.
 */
class Intervals
{
    /** @var array $intervals */
    public $intervals;
    /** @var Abonement $abonement */
    public $abonement;


    /**
     * Intervals constructor.
     * @param Abonement $abonement
     */
    function __construct($abonement = null)
    {
        if($abonement !== null)
        {
            $this->abonement = $abonement;
            $this->intervals = $abonement->getIntervals();
        }

    }

    /**
     * Возвращает время через указанное количество дней от настоящего момента
     *
     * @param int $days
     * @return DateTime|false
     */
    public static function DaysFromNow($days)
    {
        return date_add(date_create(), new DateInterval("P{$days}D"));
    }

    /**
     * Возвращает общее количество интервалов прослушиваний
     *
     * @return mixed
     */
    public function getTimesTotal(){

        $start = $this->abonement->getStart();
        $end = $this->abonement->getEnd();

        return $this->getTimesCount($this->intervals, $start, $end);
    }

    /**
     * @param Abonement $abonement
     * @return mixed
     */
    public function getTimesLeft($abonement = null){

        if($abonement === null) {
            $abonement = $this->abonement;
            $intervals = $this->intervals;
        }
        else $intervals = $abonement->getIntervals();

        $today = date_create();
        $endDate = $abonement->getEnd();
        return $this->getTimesCount($intervals,$today, $endDate);
    }

    /**
     * @param DateTime $audiosessionStart
     * @return bool
     */
    public static function isNow($audiosessionStart)
    {
        $audiosessionEnd = clone($audiosessionStart);
        $audiosessionEnd->add(new DateInterval("PT3H"));

        $currentDate = date_create();
        if($currentDate > $audiosessionStart && $currentDate < $audiosessionEnd)
            return true;

        return false;
    }

    /**
     * Возвращает количество интервалов прослушивания между датами
     *
     * @param array $intervals
     * @param DateTime $start
     * @param DateTime $end
     * @return int Количество прослушиваний за все время абонемента
     */
    public function getTimesCount($intervals = null, $start = null, $end = null)
    {
        if($intervals === null) $intervals = $this->intervals;

        $start = $this->closestIntervalStartDatetime($start, $intervals);
        $end = $this->lastIntervalEndDatetime($end, $intervals);

        $difference = date_diff($start, $end);

        $times = count($intervals);

        $count = $difference->days * $times;

        $duration = 3;
        $start_hour = (int)$start->format("G");
        $end_hour = $difference->h + $start_hour;

        foreach ($intervals as $interval) {

            if($interval < $start_hour)
                $interval += 24;

            $interval_end = $interval + $duration;

            if ($interval >= $start_hour && $interval_end <= $end_hour) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Определяет попадает ли указанный час в интервал
     *
     * @param $hour int Указывает час начала интервала
     * @param $hour_now int Указывает час который надо проверить
     * @return bool попадает ли указанный час в интервал
     */
    public function inInterval($hour, $hour_now)
    {
        $interval_end = $hour + 3;
        if($interval_end > 24) $hour_now += 24;
        if($hour_now > $hour && $hour_now < $interval_end)
            return true;
        return false;
    }



    /**
     * Сортирует интервалы в порядке следования по времени, начиная с указанного интервала
     *
     * @param int $startInterval Интервал (час начала) прослушивания
     * @param array $intervals
     * @return array
     * @throws Exception
     */
    public static function sortByStartInterval($startInterval, $intervals){

        if(count($intervals) === 0)
            throw new Exception(__METHOD__.": передан пустой массив");

        sort($intervals);

        $key = array_search($startInterval, $intervals);

        if($key === null || $key === false )
            throw new Exception(__METHOD__.": значение \$startIndex не найдено.");

        $scheduled = array_slice($intervals, 0, $key);
        $first = array_slice($intervals, $key);
        $intervals = array_merge($first, $scheduled);

        return $intervals;
    }

    /**
     * Сортирует интервалы так, чтобы первый интервал был ближайшим с указанного момента времени целым интервалом,
     * и все интервалы шли друг за другом по времени.
     *
     * Стартовое время должно быть установлено для первого интервала!
     *
     * @param array $intervals
     * @param DateTime $start
     * @return array
     */
    public static function sortByStartDatetime($intervals, $start)
    {
        return self::sortByStartInterval($start->format('G'), $intervals);
    }

    /**
     * Возвращает время начала интервала по его порядковому индексу.
     * Функция начинает индексирование по самому ближайшему неначавшемуся интервалу.
     * Если время $start == началу интервала, интервал считается неначавшимся.
     *
     * @param $intervals array
     * @param $index int
     * @param $startDate DateTime
     * @return DateTime
     */
    public function getTimeByIndex($intervals = null, $index, $startDate = null)
    {
        if($intervals === null) $intervals = $this->intervals;
        if($startDate === null) $startDate = $this->abonement->getStart();

        $intervals = self::sortByStartDatetime($intervals, $startDate);

        $times = count($intervals);
        $temp = $index / $times;

        $days = floor($temp);
        $times = $days * $times;
        $pos = $index - $times;

        if($intervals[$pos] < $intervals[0])
            $intervals[0] -= 24;

        $hours =  $intervals[$pos] - $intervals[0];

        /** @var DateTime $time Время начала сеанса*/
        $time = clone($startDate);
        $time->add(new DateInterval("P{$days}DT{$hours}H"));

        return $time;
    }

    public function getStartByIndex($intervals, $index, $startDate)
    {
        return $this->getTimeByIndex($intervals, $index, $startDate);
    }

    /**
     * Возвращает время конца интервала по порядковому индексу
     *
     * @param $intervals
     * @param $index
     * @param DateTime $startDate
     * @return DateTime
     */
    public function getEndByIndex($intervals, $index, $startDate)
    {
        /** @var DateTime $start */
        $end = $this->getStartByIndex($intervals, $index, $startDate);
        $end->add(new DateInterval('PT3H'));
        return $end;
    }

    /**
     * Возвращает начало ближайшего целого интервала, следующего за указанным временем
     *
     * @param $datetime DateTime
     * @param $intervals
     * @return DateTime
     */
    public static function closestIntervalStartDatetime($datetime, $intervals)
    {
        $start = clone($datetime);
        $hours = $datetime->format('G');
        $start->setTime($hours, 0, 0);
        if($start < $datetime)
            $start->setTime(++$hours, 0, 0);

        $min_diff = 24;
        foreach ($intervals as $interval) {
            $diff = $interval - $hours;

            if ($diff < 0)
                $diff += 24;

            if ($min_diff > $diff) {
                $min_diff = $diff;
            }
        }

        if($min_diff) $start->add(new DateInterval("PT{$min_diff}H"));

        return $start;
    }

    public static function getStartFromDate($datetime, $intervals)
    {
        return self::closestIntervalStartDatetime($datetime, $intervals);
    }

    /**
     * Возвращает конец последнего интервала по длительности абонемента, начиная с указанного времени.
     *
     * @param DateTime $startDate
     * @param array $intervals
     * @param int $duration
     * @param int $times
     * @return DateTime
     */
    public static function getEndByDuration($startDate, $intervals, $duration, $times)
    {
        $start = self::closestIntervalStartDatetime($startDate, $intervals);

        $price = new Price();
        $count = $price->getTimesCount($duration, $times);
        $lastStart = self::getTimeByIndex($intervals, $count - 1, $start );

        $lastEnd = clone($lastStart);
        $lastEnd->add(new DateInterval("PT3H"));
        return $lastEnd;
    }

    /**
     * Возвращает время конца последнего интервала до указанного времени
     *
     * @param $ending
     * @param $intervals
     * @return mixed
     */
    public function lastIntervalEndDatetime($ending = null, $intervals = null)
    {
        if($intervals === null)
            $intervals = $this->intervals;

        $endTime = clone($ending);
        $duration = 3;

        $hours = $ending->format("G");

        $min_diff = 24;

        foreach($intervals as $interval)
        {
            $end = $interval + $duration;

            $diff = $hours - $end;

            if($diff < 0)
                $diff += 24;

            if($diff < $min_diff)
                $min_diff = $diff;
        }

        if($min_diff) {
            $endTime->sub(new DateInterval("PT{$min_diff}H"));
        }
        return $endTime;
    }

    static function getTimesCountLeft($startDate, $rang1, $rang2){
        $datetime_start = date_create($startDate);
        $dateInterval = Abonement::getDateInterval($rang1);
        $datetime_end = date_add($datetime_start, $dateInterval);
        $currentDate = date_create();
        $diff = date_diff($datetime_end, $currentDate);
        $days = date_format($diff, "%d");
        $count = $days*(4 - $rang2);
        return $count;

    }


    static function getDateInterval($rang1){
        if(is_string($rang1))
            switch($rang1) {
                case '6 месяцев':
                    $option = "6 month";
                    break;
                case '3 месяца':
                    $option = "3 month";
                    break;
                case '1 месяц':
                    $option = "1 month";
                    break;
                case '3 Недели':
                    $option = "3 week";
                    break;
                case '2 Недели':
                    $option = "2 week";
                    break;
                case '1 Неделя':
                    $option = "1 week";
                    break;
            }
        else
            switch($rang1){
                case 1:
                    $option = "6 month";
                    break;
                case 2:
                    $option = "3 month";
                    break;
                case 3:
                    $option = "1 month";
                    break;
                case 4:
                    $option = "3 week";
                    break;
                case 5:
                    $option = "2 week";
                    break;
                case 6:
                    $option = "1 week";
                    break;
            }

        $dateInterval = date_interval_create_from_date_string($option);
        return $dateInterval;
    }

    public function getStartDate($format = null){
        $datetime = ($this->paid) ? date_create($this->created) : date_create() ;
        if($format) return date_format($datetime, $format);
        return $datetime;
    }

    public function getDurationInterval($format = null){
        $interval = self::getDateInterval($this->duration);
        if($format) return date_format($interval, $format);
        return $interval;
    }

    static function getIntervalByIndex($index, $reverse = false){

        $intervals = array(
            1 => "6:00 - 9:00",
            2 => "7:00 - 10:00",
            3 => "8:00 - 11:00",
            4 => "9:00 - 12:00",
            5 => "10:00 - 13:00",
            6 => "11:00 - 14:00",
            7 => "12:00 - 15:00",
            8 => "13:00 - 16:00",
            9 => "14:00 - 17:00",
            10 => "15:00 - 18:00",
            11 => "16:00 - 19:00",
            12 => "17:00 - 20:00",
            13 => "18:00 - 21:00",
            14 => "19:00 - 22:00",
            15 => "20:00 - 23:00",
            16 => "21:00 - 0:00",
            17 => "22:00 - 1:00",
            18 => "23:00 - 2:00",
            19 => "0:00 - 3:00",
            20 => "1:00 - 4:00",
            21 => "2:00 - 5:00",
            22 => "3:00 - 6:00",
            23 => "4:00 - 7:00",
            24 => "5:00 - 8:00",
        );

        if($reverse){
            $indexes = array_flip($intervals);
            return $indexes[$index];
        }

        return $intervals[index];
    }

    public static function getSheduleList($abonement, $start_datetime = null, $end_datetime = null){

        /** @var Abonement $abonement */
        $intervals = $abonement->getIntervals();

        sort($intervals);

        $audiosessions = Audiosession::getAudiosessionsFromIDString($abonement->asids);

        $abonement_start_datetime = $abonement->getStart();
        $abonement_end_datetime = clone($abonement->getEnd());

        if($start_datetime === null || $start_datetime < $abonement_start_datetime) $start_datetime = clone($abonement_start_datetime);
        if($end_datetime === null || $end_datetime > $abonement_end_datetime) $end_datetime = clone($abonement_end_datetime);

        $temp_datetime = clone(date_time_set($abonement_start_datetime, 0, 0, 0));

        $audiosessions_index = 0;

        $shedule = array();
        for( ; $temp_datetime < $end_datetime; $temp_datetime = date_modify($temp_datetime, "+1 day") ){

            for($i = 0; $i < count($intervals); $i++) {

                $temp_datetime = date_time_set($temp_datetime, $intervals[$i], 0, 0);

                if ($temp_datetime < $abonement_start_datetime || $temp_datetime > $end_datetime) {
                    continue;
                }

                if ($temp_datetime > $start_datetime && $temp_datetime < $end_datetime) {

                    $shedule[] = array(
                        "datetime" => clone $temp_datetime,
                        "asess" => $audiosessions[$audiosessions_index]
                    );

                }

                if ( ++$audiosessions_index >= count($audiosessions)) $audiosessions_index = 0;
            }
        }

        return $shedule;

    }
}