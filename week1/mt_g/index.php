<?php

function fizzBuzz($num){

    $num += 1; //start at 1, move the entire list up
    
    if($num % 3 == 0 and $num % 2 == 0){
        return "fizz buzz";
    }
    elseif($num % 3 == 0){
        return "fizz";
    }
    elseif($num % 2 == 0){
        return "buzz";
    }
    else{
        return $num;
    }

    //conditional statements determining multiples of 2, 3, or both using modulus

}

for($i = 0; $i < 100; $i++){
    echo '<p>';
    echo fizzBuzz($i);
    echo '</p>';
}
