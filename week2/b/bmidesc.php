<?php
function bmidesc($bmi){//receive pre-calculated bmi
    if($bmi >= 30) {
        return "Obese";
    }
    elseif ($bmi >= 25) {
        return "Overweight";
    }
    elseif ($bmi >= 18.5) {
        return "Normal weight";
    }
    else{
        return "Underweight";
    }
    //return a string depending on how large the number is
    
}