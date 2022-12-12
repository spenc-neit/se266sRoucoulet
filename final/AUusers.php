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

if(isset($_GET['action'])){
    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'userID');

    if($action == 'update'){
        $row = getARecord($id, 'forum_users');
        $UN = $row['username'];
        $PW = $row['pass'];
        $EM = $row['email'];
        $VE = $row['verified'];
        $BD = $row['birthday'];
        $DJ = $row['joined'];
        $RK = $row['userRank'];
        $AP = $row['amtPosts'];
        $PV = $row['privilege'];
    }else{
        $UN = '';
        $PW = '';
        $EM = '';
        $VE = '';
        $BD = '';
        $DJ = '';
        $RK = '0';
        $AP = '0';
        $PV = '';
    }

   
} elseif(isset($_POST['action'])){
    $action = filter_input(INPUT_POST, 'action');
    $id = filter_input(INPUT_POST, 'userID');
    $UN = filter_input(INPUT_POST, 'inputUN');
    $PW = filter_input(INPUT_POST, 'inputPW');
    $EM = filter_input(INPUT_POST, 'inputEM');
    $VE = filter_input(INPUT_POST, 'inputVE');
    $BD = filter_input(INPUT_POST, 'inputBD');
    $DJ = filter_input(INPUT_POST, 'inputDJ');
    $RK = filter_input(INPUT_POST, 'inputRK');
    $AP = filter_input(INPUT_POST, 'inputPA');
    $PV = filter_input(INPUT_POST, 'inputPV');    
}

if(isPostRequest() AND $action == 'add'){
    $dataPara = array($UN, $PW, $EM, $VE, $BD, $DJ, $RK, $AP, $PV);
    $result = addARecord($dataPara);
    header('Location: VSDUsers.php');
} elseif (isPostRequest() AND $action == 'update'){
    $dataPara = array($UN, $PW, $EM, $VE, $BD, $DJ, $RK, $AP, $PV, $id);
    $result = updateARecord($dataPara);
}

if(empty($_GET) AND empty($_POST)){
    $UN = '';
    $PW = '';
    $EM = '';
    $VE = '';
    $BD = '';
    $DJ = '';
    $RK = '0';
    $AP = '0';
    $PV = '';
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
            background-color:white;
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
        <h1 class='my-2'>Add User</h1>
        <?php elseif($action == 'update'):?> <!--if the passed action is 'update'-->
        <h1 class='my-2'>Update User</h1>
        <?php endif;?>

        <form action='AUusers.php' method='post' style='text-align:left;' class='form-horizontal'>

            <input type='hidden' name='action' value='<?= $action ?>'>
            <input type='hidden' name='userID' value='<?= $id ?>'>

            <div class='form-group'>
                <label class='control-label' for='inputUN'>Username:</label>
                <input type='text' name='inputUN' value='<?= $UN ?>' class='form-control' required>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputPW'>Password:</label>
                <input type='text' name='inputPW' value='<?= $PW ?>' class='form-control' required>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputEM'>Email:</label>
                <input type='email' name='inputEM' value='<?= $EM ?>' class='form-control' required>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputVE'>Email verified?</label>
                <?php if($VE == 1):?>
                    <input type='checkbox' name='inputVE' value='1' class='form-control col-sm-2' checked>
                <?php else:?>
                    <input type='checkbox' name='inputVE' value='1' class='form-control col-sm-2'>
                <?php endif;?>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputBD'>Birthday:</label>
                <input type='date' name='inputBD' value='<?= $BD ?>' class='form-control' required>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputDJ'>Date joined:</label>    
                <input type='date' name='inputDJ' value='<?= $DJ ?>' class='form-control' required>
            </div>

            <div class='form-group'> 
                <label class='control-label' for='inputRK'>Rank:</label>   
                <input type='text' name='inputRK' value='<?= $RK ?>' class='form-control' required>
            </div>

            <div class='form-group'>  
                <label class='control-label' for='inputPA'>Amt. of Posts:</label>  
                <input type='text' name='inputPA' value='<?= $AP ?>' class='form-control' required>
            </div>

            <div class='form-group'>  
                <label class='control-label' for='inputPV'>Privilege level:</label>

                <?php switch ($PV):
                    case('default'):?>
                        <select name='inputPV' class='form-control'>
                            <option value='default' selected>Default</option>
                            <option value='owner'>Owner</option>
                        </select>
                    <?php break;
                    case('Owner'):?>
                        <select name='inputPV' class='form-control'>
                            <option value='default'>Default</option>
                            <option value='owner' selected>Owner</option>
                        </select>
                    <?php break;
                    default:?>
                        <select name='inputPV' class='form-control'>
                            <option value='default' selected>Default</option>
                            <option value='owner'>Owner</option>
                        </select>
                    <?php break;
                endswitch;?>

            </div>

            <button type='submit' class='btn btn-outline-success mb-5'>Submit</button>
        </form>

    </div>

    <?php include_once 'includes/footer.php';?>

</body>
</html>