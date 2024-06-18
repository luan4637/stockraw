<?php

if (!function_exists('createDateFormat')) {
    function createDateFormat($datetime, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
    {
        $timestamp = DateTime::createFromFormat('!' . $fromFormat, $datetime)->getTimestamp();

        return date($toFormat, $timestamp);
    }
}

if (!function_exists('getWeekday')) {
    function getWeekday(int $numDay = 0, string $format = 'Y-m-d')
    {
        $day = date('l');
        if ($day == 'Saturday' || $day == 'Sunday') {
            $numDay -= 1;
        } else {
            for ($i = 0; $i >= $numDay; $i--) {
                $curday = date('m-d', strtotime($i . ' weekday'));
                if ($curday == '09-01' || $curday == '09-04') {
                    $numDay -= 1;
                }
            }
        }

        $weekday = date($format, strtotime($numDay . ' weekday'));

        return $weekday;
    }

    function getYesterday()
    {
        return getWeekday(-1);
    }

    function getToday()
    {
        return getWeekday();
    }
}

if (!function_exists('isWorkingHour')) {
    function isWorkingHour()
    {
        $day = date('l');
        $curHour = date('H');

        if ($day == 'Saturday' || $day == 'Sunday' || $curHour >= 15) {
            return false;
        }

        return true;
    }
}
