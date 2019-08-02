<?php

namespace app\helpers;

class DateHelper
{
    const MONTHS = [
        'янв',
        'фев',
        'мар',
        'апр',
        'май',
        'июн',
        'июл',
        'авг',
        'сен',
        'окт',
        'ноя',
        'дек',

    ];

    public static function formatDate($date)
    { 
        $formatDate = $date->format('j-n-Y');
        $dateArr = explode('-', $formatDate);
        $month = static::MONTHS[$dateArr[1] - 1];
        $newDate = $dateArr[0] . " " . $month . " " . $dateArr[2];
        return $newDate;
    }
}
