<?php
function dd($data){
    echo '<pre>'; //set up pre tag for nicely formatted dump
    die(var_dump($data)); //dump the data, then break
    echo '</pre>'; //I included it because it was in the video, but isn't this line of code useless since it comes after die?
}