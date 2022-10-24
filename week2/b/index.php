<?php

require_once "bmi.php";
require_once "bmidesc.php";
require_once "age.php";
// require_once "indexfront.php";

$error = "";
$fnameInput = "";
$lnameInput = "";
$marriedInput = "";
$dobInput = "";
$weightInput = "";
$fheightInput = "";
$iheightInput = "";


if(isset($_POST['submitbtn'])){

    $fnameInput = filter_input(INPUT_POST, 'fname');
    if($fnameInput == ""){
        $error .= "<li>Enter a first name.</li>";
    }

    $lnameInput = filter_input(INPUT_POST, 'lname');
    if($lnameInput == ""){
        $error .= "<li>Enter a last name.</li>";
    }

    $marriedInput = filter_input(INPUT_POST, 'married');
    if($marriedInput == ""){
        $error .= "<li>Select a marriage status.</li>";
    }

    $dobInput = filter_input(INPUT_POST, 'dob');
    if($dobInput == ""){
        $error .= "<li>Select a valid date.</li>";
    }

    $weightInput = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
    if($weightInput == "" or (float) $weightInput < 0 or (float) $weightInput > 1500){
        $error .= "<li>Weight must be a valid number.</li>";
    } //apparently the heaviest person ever was 1400 lbs. can't fathom that but w/e, I worked with it and gave a margin of 100 lbs

    $fheightInput = filter_input(INPUT_POST, 'fheight', FILTER_VALIDATE_FLOAT);
    if($fheightInput == "" or (int) $fheightInput < 0 or (int) $fheightInput > 8){
        $error .= "<li>Height (ft) must be a valid number.</li>";
    }

    $iheightInput = filter_input(INPUT_POST, 'iheight', FILTER_VALIDATE_FLOAT);
    if($iheightInput == "" or (int) $iheightInput < 0 or (int) $iheightInput > 12){
        $error .= "<li>Height (in) must be a valid number.</li>";
    }


    if($error == ""){
        
        $bmi = bmi($fheightInput, $iheightInput, $weightInput);
        $bmi = round($bmi, 1);
        $classification = bmidesc($bmi);

        require "confirm.php";


    } else {
        echo "<p class='err'>Please fix the following and resubmit</p>";
        echo "<ul class='err'>";
        echo $error;
        echo "</ul>";
    }

    // echo "<pre>";
    // echo var_dump($_POST);
    // echo "</pre>";
}


?>