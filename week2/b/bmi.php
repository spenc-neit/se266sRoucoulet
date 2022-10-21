<?php

function bmi($ft, $inch, $weight){
    $height = (($ft * 12) + $inch) * .0254;
    $weight = $weight / 2.20462;

    $bmi = $weight / ($height * $height);

    return $bmi;
}