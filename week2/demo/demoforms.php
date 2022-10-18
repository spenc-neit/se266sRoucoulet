<?php
    if (isset($_POST['submitBtn'])){
        echo "form submitted<br />";
        $value = filter_input(INPUT_POST, 'val1', FILTER_VALIDATE_FLOAT);
        if ($value == ""){
            echo "Not a float";
        } else{
            echo $value;
        }
        //var_dump ($_POST);
    } else {
        echo "initial load of form";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Forms</title>
</head>
<body>
    <h1>Demo Forms</h1>
    <form action="demoforms.php" method="post">
        <input type="text" name="val1" value="whatever" />
        <input type="submit" name="submitBtn" />
    </form>
</body>
</html>