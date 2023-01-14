<?php
function getStartOfWeekDate($date = null)
{
    if ($date instanceof \DateTime) {
        $date = clone $date;
    } else if (!$date) {
        $date = new \DateTime();
    } else {
        $date = new \DateTime($date);
    }

    $date->setTime(0, 0, 0);

    if ($date->format('N') == 1) {
        // If the date is already a Monday, return it as-is
        // echo $date;
        return $date;
    } else {
        // Y-m-d H:i:s
        // Otherwise, return the date of the nearest Monday in the past
        // This includes Sunday in the previous week instead of it being the start of a new week
        $date->modify('monday this week')->format('Y-m-d H:i:s');
        return $date->modify('monday this week')->format('Y-m-d H:i:s');
    }

    /*
    // Calculate the date of Monday for the current week
    $monday = date('Y-m-d', strtotime('monday this week',strtotime($reservasUsuario[0]->date)));
    // Calculate the date of Friday for the current week
    $friday = date('Y-m-d', strtotime('friday this week',strtotime($reservasUsuario[0]->date)));
*/
}

function getEndOfWeekDate($date = null)
{
    if ($date instanceof \DateTime) {
        $date = clone $date;
    } else if (!$date) {
        $date = new \DateTime();
    } else {
        $date = new \DateTime($date);
    }

    $date->setTime(0, 0, 0);

    if ($date->format('N') == 1) {
        // If the date is already a Monday, return it as-is
        // echo $date;
        return $date;
    } else {
        // Otherwise, return the date of the nearest Monday in the past
        // This includes Sunday in the previous week instead of it being the start of a new week
        // last friday
        $date->modify('friday this week')->format('Y-m-d H:i:s');
        return $date->modify('friday this week')->format('Y-m-d H:i:s');
    }
}

