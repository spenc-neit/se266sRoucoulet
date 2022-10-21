<?php
function bmidesc($bmi){
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
    
}