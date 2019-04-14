<?php

/**
 * Вспомогательный класс для форматирования
 */
class Format
{
    /**
     *
     *
     * @param DateTime $datetime
     * @return string
     */
    public static function MSDateTime($datetime)
    {
        return date_format($datetime,"Y-m-d H:i:s");
    }

    public static function quote($value)
    {
        return "'".$value."'";
    }
}