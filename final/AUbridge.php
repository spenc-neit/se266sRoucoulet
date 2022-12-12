<?php

include_once 'includes/header.php';
include_once __DIR__ . '/model/db_functions.php';
include_once __DIR__ . '/includes/postcheck.php';

// echo '<pre style="background-color:white;">';
// echo 'post';
// var_dump($_POST);
// echo 'get';
// var_dump($_GET);
// echo '</pre>';

$badUID = 0;
$badFID = 0;

if(isset($_GET['action'])){
    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'bridgeID');

    if($action == 'update'){
        $row = getARecord($id, 'bridge');
        $uID = $row['userID'];
        $fID = $row['forumID'];
    } else {
        $uID = '';
        $fID = '';
    }
} elseif (isset($_POST['action'])){
    $action = filter_input(INPUT_POST, 'action');
    $id = filter_input(INPUT_POST, 'bridgeID');
    $uID = filter_input(INPUT_POST, 'inputUID');
    $fID = filter_input(INPUT_POST, 'inputFID');
}

if(isPostRequest() AND $action == 'add'){
    if(!isValidUID((int)$uID) OR !isValidFID((int)$fID)){
        if(!isValidFID((int)$fID)){
            $badFID = 1;
        }
        if(!isValidUID((int)$uID)){
            $badUID = 1;
        }
    } else{
        $dataPara = array($uID, $fID);
        $result = addARecord($dataPara);
        header('Location: VSDbridge.php');
    }

    // if(isValidUID($uID)){
    //     echo 'uID works';
    //     var_dump($uID);
    // }

    // if(isValidFID($fID)){
    //     echo 'fID works';
    //     var_dump($fID);
    // }

    // if(!isValidUID($uID)){
    //     echo 'uID does not works';
    //     var_dump($uID);
    // }

    // if(!isValidFID($fID)){
    //     echo 'fID does not works';
    //     var_dump($fID);
    // }

} elseif (isPostRequest() AND $action == 'update'){
    if(!isValidUID($uID) OR !isValidFID($fID)){
        if(!isValidFID($fID)){
            $badFID = 1;
        }
        if(!isValidUID($uID)){
            $badUID = 1;
        }
    } else{
        $dataPara = array($uID, $fID, $id);
        $result = updateARecord($dataPara);
    }
}

if(empty($_GET) AND empty($_POST)){
    $fID = '';
    $uID = '';
    $action = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #cont{
            width:50%;
        }
    </style>
    <script>
        var header = document.querySelector('#header')
        var headerHeight = header.offsetHeight
        var body = document.querySelector('body')
        var html = document.querySelector('html')
        html.style.height = "100%"
        var htmlHeight = html.offsetHeight
        var newHeight = htmlHeight - headerHeight
        html.style.height = String(newHeight + 'px')
        body.style.height = String(newHeight + 'px')
    </script>
</head>
<body>
    
    <div class='h-100' id='cont'>

        <?php if (($action == 'add') OR (empty($_GET) AND empty($_POST))):?> <!--if the passed action is 'add' or *both* GET and POST are empty (see above 4-line comment)-->
        <h1 class='my-2'>Add Bridge</h1>
        <?php elseif($action == 'update'):?> <!--if the passed action is 'update'-->
        <h1 class='my-2'>Update Bridge</h1>
        <?php endif;?>

        <form action='AUbridge.php' method='post' style='text-align:left;' class='form-horizontal'>
            <input type='hidden' name='badUID' id='badUID' value='<?=$badUID?>'>
            <input type='hidden' name='badFID' id='badFID' value='<?=$badFID?>'>
            <input type='hidden' name='action' value='<?=$action?>'>
            <input type='hidden' name='forumID' value='<?=$id?>'>

            <div class='form-group'>
                <label class='control-label' for='inputUID'>User ID:</label>
                <input type='number' class='form-control' name='inputUID' id='inputUID' required value='<?$uID?>'>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputFID'>Forum ID:</label>
                <input type='number' class='form-control' name='inputFID' id='inputFID' required value='<?$fID?>'>
            </div>

            <button type='submit' class='btn btn-outline-success'>Submit</button>
        </form>

    </div>

    <script>
        var badUID = document.querySelector('#badUID').getAttribute('value')
        console.log(badUID)
        if(badUID == 1){
            alert("Users ID number does not match an existing user. Please enter a valid ID. For list of valid IDs, check the View & Search page for the Users table.")
        }
        var badFID = document.querySelector('#badFID').getAttribute('value')
        console.log(badFID)
        if(badFID == 1){
            alert("Forum ID number does not match an existing forum. Please enter a valid ID. For list of valid IDs, check the View & Search page for the Forums table.")
        }
    </script>

    <?php include_once 'includes/footer.php';?>

</body>
</html>