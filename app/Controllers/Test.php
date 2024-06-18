<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        $numDay = -2;
        for ($i = 0; $i >= $numDay; $i--) {
            $day = date('m-d', strtotime($i . ' weekday'));
            if ($day == '09-01' || $day == '09-04') {
                $numDay -= 1;
            }
        }
        $weekday = date('Y-m-d', strtotime($numDay . ' weekday'));
        
        // if ($weekday == '2023-09-01' || $weekday == '2023-09-04') {
        //     $weekday = date('Y-m-d', strtotime(($numDay - 2) . ' weekday'));
        // }

        echo $weekday;
    }
}
