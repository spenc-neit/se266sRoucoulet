<?php

function age ($bdate) {
    $date = new DateTime($bdate);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
    //calculate age given the user's birthday and the current date/time
 }