<?php

/**
 * Класс для работы с расценками и конструирования планов абонементов.
 * Стоимость абонемента определяется по длительности и количеству прослушиваний.
 * Абонемент считается начавшимся с начала первого сеанса. Время окончания абонемента
 * рассчитывается как конец последнего сеанса.
 */
class Price
{
    public $basicPrice = 2000;
    public $periods;
    public $times;

    function __construct()
    {
        $this->periods = array(
            1 => array( "label" => "6 месяцев", "days" => 183 ),
            2 => array( "label" => "3 месяца", "days" => 92 ),
            3 => array( "label" => "1 месяц", "days" => 31),
            4 => array( "label" => "3 недели", "days" => 21),
            5 => array( "label" => "2 недели", "days" => 14),
            6 => array( "label" => "1 неделя", "days" => 7)
        );

        $this->times = array(
            1 => "1 прослушивание",
            2 => "2 прослушивания",
            3 => "3 прослушивания"
        );

    }

    public function getPriceRows(){

        for($period = 1; $period <= 6; $period++)
        {
            for($times = 1; $times <= 3; $times++)
            {
                $days = $this->periods[$period]['days'];

                $listen_count = $days * (4 - $times);

                $rang = ( $period - 1) * 3 + ($times - 1);

                $single_listen = ($this->basicPrice + $rang * 187.5) / 276;

                $cost = $single_listen * $listen_count ;

                $rows[] = array(
                    "period" => $this->periods[$period]['label'],
                    "times" => $this->times[4-$times],
                    "cost" => round($cost,2),
                    "days" => $days,
                    "listen_count" => $listen_count,
                    "listen_one_cost" => round($single_listen,2)
                );
            }
        }

        return $rows;

    }

    /**
     * Рассчитывает стоимость абонемента
     *
     * Формула для рассчета цены:
     * БАЗОВАЯ_ЦЕНА = 2000р
     * Цена = СТОИМОСТЬ_ПРОСЛУШИВАНИЯ * КОЛ-ВО_ПРОСЛУШИВАНИЙ
     * СТОИМОСТЬ_ПРОСЛУШИВАНИЯ = (БАЗОВАЯ_ЦЕНА + РАНГ * 185,5) / 276
     * РАНГ - определяется комбинацией длительности абонемента и количества прослушиваний
     * вот таким образом:
     * 6 мес, 3 прослушивания - ранг 1
     * 6 мес, 2 прослушивания - ранг 2
     * 6 мес, 1 прослушивания - ранг 3
     * 3 мес, 3 прослушивания - ранг 4
     * 3 мес, 2 прослушивания - ранг 5
     *
     * @param $abonement
     * @return float|null
     */
    public function getCost($abonement = null){

        // Если не указаны продолжительность абонемента
        // и количество прослушиваний
        if(!$abonement->duration || !$abonement->times)
            return null;

        // Количество дней
        $days = $this->periods[$abonement->duration]['days'];

        // Количество прослушиваний
        $listen_count = $days * ($abonement->times);

        // Вычисляем ранг
        $rang = ( $abonement->duration - 1) * 3 + (3 - $abonement->times);

        // Цена одного прослушивания
        $single_listen = ($this->basicPrice + $rang * 187.5) / 276;

        // Цена всего абонемента
        $cost = $single_listen * $listen_count ;

        return round($cost, 2);
    }

    public function getCostSingle($abonement)
    {
        $summ = $this->getCost($abonement);
        $count = $this->getTimesCount();
        return round( $summ / $count, 2);
    }

    /**
     * Рассчитывает стоимость оставшихся прослушиваний
     *
     * @param Abonement $abonement
     * @return float
     */
    public function getLeftSum($abonement){

        if($abonement->outsum === null) return null;

        $Intervals = new Intervals($abonement);

        $outsum = $abonement->outsum;
        $timesLeft = $Intervals->getTimesLeft();
        $timesTotal = $Intervals->getTimesTotal();

        $leftSum = round(($outsum / $timesTotal) * $timesLeft, 2);

        return $leftSum;


    }

    /**
     * Возвращает HTML для формы оплаты абонемента
     *
     * @param Abonement $abonement Абонемент для которого выводится форма
     * @return string
     */
    public function getPayForm($abonement){

        global $config;

        $intervals = new Intervals($abonement);

        $summ = $this->getCost($abonement);

        $plan = $abonement->getPlanList();

        $user = User::getById($abonement->owner);

        $start = $abonement->getStart()->format("d.m.y");
        $end = $abonement->getEnd()->format("d.m.y");

        $order = "";
        foreach($plan as $audiosession){
            $order .= $audiosession !== "0" ? "<li>".$audiosession['caption']."</li><input name='audiosessionlist[]' type='hidden' value='{$audiosession['id']}'>" : '<li>...</li>';
        }


        $mrh_login = $config['payment']['login'];       // Идентификатор магазина

        $pass1 = $config['payment']['password1test'];   // Пароль магазина

        $inv_id = $abonement->id;                // Идентификатор заказа в базе данных сайта

        $inv_desc = $abonement->description;     // Описание заказа. Максимальная длина — 100 символов.
        // Эта информация отображается в интерфейсе ROBOKASSA и в Электронной квитанции
        $in_curr = "ApplePayRIBR";
        $out_summ = $summ;                  // Сумма которую нужно заплатить

        $IsTest = 1;                        // Флаг - тестовый платеж

        $email = $user->email;              // E-Mail покупателя автоматически подставляется
        //в платёжную форму ROBOKASSA. Пользователь может изменить его в процессе оплаты.

        $crc = md5("$mrh_login:$out_summ:$inv_id:$pass1");          // Контрольная сумма - хэш, число в 16-ричной форме и любом регистре (0-9, A-F),
        // рассчитанное методом указанным в Технических настройках магазина.
        $ExpirationDate = "";

        return "<div class=\"abonements-block\">
                    <form id=sendpayform action='https://auth.robokassa.ru/Merchant/Index.aspx' method=POST>
                    
                    <input type=hidden name=MrchLogin value='$mrh_login'>
                    <input type=hidden name=OutSum value='".$out_summ."'>
                    <input type=hidden name=InvId value='$inv_id'>
                    <input type=hidden name=Desc value='$inv_desc'>
                    <input type=hidden name=IncCurrLabel value='$in_curr'>
                    <input type=hidden name=SignatureValue value=$crc>
                    <input type=hidden name=Email value='$email'>
                    <input type=hidden name=ExpirationDate value='$ExpirationDate'>
                    <input type=hidden name=IsTest value=$IsTest>  
                    
                    <div class=\"abonements-block-section clearfix\">
                        <div class=\"left-field\">Срок действия</div>
                        <div class=\"right-field\">$start - $end</div>

                    </div>
                    
                    <div class=\"abonements-block-section clearfix\">
                        <div class=\"left-field\">Количество прослушиваний в день</div>
                        <div class=\"right-field\">{$abonement->times}</div>

                    </div>
                    
                    <div class=\"abonements-block-section clearfix\">
                        <div class=\"field\">Порядок прослушивания</div>
                        <ul>$order</ul>

                    </div>

                    <div class=\"abonements-block-section no-border clearfix\">
                        <div class=\"left-field\">Стоимость</div>
                        <div class=\"right-field price-field\">$out_summ</div>
                    </div>
                    

                    <button type='submit' class=\"btn btn-primary\">Оплатить</button>
                    </form>

                </div>";
    }


    /**
     * Возвращает количество прослушиваний по прайсу, для указанной длительности и кол-ву прослушиваний
     *
     * @param $period
     * @param $times
     * @return mixed
     */
    public function getTimesCount($period, $times){
        return $this->periods[$period]['days'] * $times;
    }

}