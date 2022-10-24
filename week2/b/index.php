<?php

require_once "bmi.php";
require_once "bmidesc.php";
require_once "age.php";

$error = "";
$fnameInput = "";
$lnameInput = "";
$marriedInput = "";
$dobInput = "";
$weightInput = "";
$fheightInput = "";
$iheightInput = "";
$age = "";
//define input variables + empty error variable + empty calculated age variable


if(isset($_POST['submitbtn'])){ //check if the form has passed any data

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
    }//I think 8 feet is a reasonable place to stop

    $iheightInput = filter_input(INPUT_POST, 'iheight', FILTER_VALIDATE_FLOAT);
    if($iheightInput == "" or (int) $iheightInput < 0 or (int) $iheightInput > 12){
        $error .= "<li>Height (in) must be a valid number.</li>";
    }//can't be more than 12 inches, can't be negative

    //receive user input, store in variables, and filter for valid input.
    //if input is invalid somehow, append an error message (inside a list item) to the $error variable


    if($error == ""){ //if there are no error messages,
        
        $bmi = bmi($fheightInput, $iheightInput, $weightInput); //calculate bmi given the user's input
        $bmi = round($bmi, 1); //round to the nearest tenth
        $classification = bmidesc($bmi); //determine classification of bmi
        $age = age($dobInput); //calculate person's age given their birthday

        require "confirm.php"; //run the confirmation page


    } else { //if there are error messages,
        echo "<p class='err'>Please fix the following and resubmit</p>"; //display an error message in red
        echo "<ul class='err'>"; //open a list in red
        echo $error; //display error messages, formatted as list items
        echo "</ul>";
    }

    // echo "<pre>";
    // echo var_dump($_POST);
    // echo "</pre>";
    // debugging var dump stuff
}
//if there is no data from the form, do nothing


?>