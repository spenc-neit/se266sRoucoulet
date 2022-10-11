<?php

//separated files like guy in video did

require 'functions.php'

$task = [
    'title' => 'bake a cake',
    'budget' => 40,
    'deadline' => '6 hours after you arrive home w/ your ingredients',
    'theme' => 'spooky season',
    'completed' => true
];
//define list detailing the task

require 'index.view.php'; //require the display page
//note to self - [require index.view.php], the file that contains the HTMl, goes at the end because we want it to display after all processing
//if it were placed earlier, like before $task was defined, $task wouldn't be there to be processed in index.view.php