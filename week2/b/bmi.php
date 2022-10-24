<?php

function bmi($ft, $inch, $weight){ //receive user's height in ft and inches, and weight in lbs
    $height = (($ft * 12) + $inch) * .0254; //convert height to meters
    $weight = $weight / 2.20462; //convert weight to kg

    $bmi = $weight / ($height * $height); //calculate bmi using these converted numbers

    return $bmi; //return calculated bmi
}