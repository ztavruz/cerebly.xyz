<?php

/**
 * Class Tariff
 *
 * Содержит функции рассчетов по прайсу
 *
 */
class Tariff
{
    const basicPrice = 2000;

    public static function getPeriods()
    {
        $periods = array(
            1 => array( "label" => "6 месяцев", "days" => 183 ),
            2 => array( "label" => "3 месяца", "days" => 92 ),
            3 => array( "label" => "1 месяц", "days" => 31),
            4 => array( "label" => "3 недели", "days" => 21),
            5 => array( "label" => "2 недели", "days" => 14),
            6 => array( "label" => "1 неделя", "days" => 7)
        );
    }

    public static function getTimes()
    {
        $times = array(
            1 => "1 прослушивание",
            2 => "2 прослушивания",
            3 => "3 прослушивания"
        );
    }

    public static function h()
    {

    }





}