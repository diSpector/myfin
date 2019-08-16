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

    // возвращает массив дат между 2 датами ($start и $end) включительно - в настоящее время не используется
    public static function getDatesFromRange($datesArr, $format = 'Y-m-d') { 
      
        $array = [];
          
        // Variable that store the date interval 
        // of period 1 day 
        $interval = new \DateInterval('P1D'); 
    
        $realEnd = new \DateTime($datesArr[1]); 
        $realEnd->add($interval); 
      
        $period = new \DatePeriod(new \DateTime($datesArr[0]), $interval, $realEnd); 
      
        // Use loop to store date into array 
        foreach($period as $date) {                  
            $array[] = $date->format($format);  
        } 
      
        // Return the array elements 
        return $array; 
    } 
}
