<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Task C</title>
</head>
<body>

    <ul>

        <h1>Animals</h1> <!--header-->

        <?php

            foreach($animals as $index){
                echo "<li>{$index}</li>";
            }
            //loop through the $animals list, returning the current list item ($index) in an <li> to add into a <ul>
        ?>

    </ul>
    
</body>
</html>