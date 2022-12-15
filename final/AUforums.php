<?php

//!!!!!-----------------------------------------------------------------------------------------------------------------------------------------------------!!!!!
//  check AUbridge.php for full documentation! the two pages work almost exactly the same but for different tables. differences will be touched upon here though.
//!!!!!-----------------------------------------------------------------------------------------------------------------------------------------------------!!!!!

include_once 'includes\header.php';
include_once 'model\db_functions.php';
include_once 'includes\postcheck.php';

// echo '<pre style="background-color:white;">';
// echo 'post';
// var_dump($_POST);
// echo 'get';
// var_dump($_GET);
// echo '</pre>';



$badUID = 0;

if(isset($_GET['action'])){
    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'forumID');

    if($action == 'update'){
        $row = getARecord($id, 'forums');
        $CR = $row['creator'];        
        $TL = $row['title'];    
        $CG = $row['category'];    
        $CD = $row['created'];    
        $PD = $row['pinned'];    
        $OR = $row['openToReply'];    
        $AR = $row['amtReplies'];    
        $LP = $row['lastPost'];    
    }else{
        $CR = '';
        $TL = '';
        $CG = '';
        $CD = '';
        $PD = '';
        $OR = '';
        $AR = '';
        $LP = '';
    }
}elseif(isset($_POST['action'])){
    $action = filter_input(INPUT_POST, 'action');
    $id = filter_input(INPUT_POST, 'forumID');    
    $CR = filter_input(INPUT_POST, 'inputCR'); //text
    $TL = filter_input(INPUT_POST, 'inputTL'); //text
    $CG = filter_input(INPUT_POST, 'inputCG'); //dropdown
    $CD = filter_input(INPUT_POST, 'inputCD'); //date
    $PD = filter_input(INPUT_POST, 'inputPD'); //bool
    $OR = filter_input(INPUT_POST, 'inputOR'); //bool
    $AR = filter_input(INPUT_POST, 'inputAR'); //num
    $LP = filter_input(INPUT_POST, 'inputLP'); //date
}

if(isPostRequest() AND $action == 'add'){
    $dataPara = array($CR, $TL, $CG, $CD, $PD, $OR, $AR, $LP);
    if(isValidUID($CR)){
        $result = addARecord($dataPara);
        echo 'help';
        header('Location: VSDforums.php');
    } else {
        echo 'hi';
        $badUID = 1;
    }

} elseif(isPostRequest() AND $action == 'update'){
    if(isValidUID($CR)){
        $dataPara = array($CR, $TL, $CG, $CD, $PD, $OR, $AR, $LP, $id);
        $result = updateARecord($dataPara);
        header('Location: VSDforums.php');

    } else {
        $badUID = 1;
    }
    } 

    
    

if(empty($_GET) AND empty($_POST)){
    $CR = '';
    $TL = '';
    $CG = '';
    $CD = '';
    $PD = '';
    $OR = '';
    $AR = '';
    $LP = '';
    $action = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        #cont{
            width:50%;
        }
    </style>
</head>
<body>
    
    <div class='h-100' id='cont'>

        <?php if (($action == 'add') OR (empty($_GET) AND empty($_POST))):?> <!--if the passed action is 'add' or *both* GET and POST are empty (see above 4-line comment)-->
        <h1 class='my-2'>Add Forum</h1>
        <?php elseif($action == 'update'):?> <!--if the passed action is 'update'-->
        <h1 class='my-2'>Update Forum</h1>
        <?php endif;?>

        <form action='AUforums.php' method='post' style='text-align:left;' class='form-horizontal'>

            <input type='hidden' name='badUID' id='badUID' value='<?=$badUID?>'>
            <input type='hidden' name='action' value='<?=$action?>'>
            <input type='hidden' name='forumID' value='<?=$id?>'>

            <div class='form-group'>
                <label class='control-label' for='inputTL'>Title:</label>
                <input type='text' name='inputTL' value='<?=$TL?>' class='form-control' required>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputCR'>Creator:</label>
                <input type='text' name='inputCR' value='<?=$CR?>' placeholder='User ID goes here. Refer to table below for valid IDs' class='form-control' required>
                <?php if($action == 'update'):?>
                    <small class='control-label text-muted'>User #<?=$CR?>: <?=getUsername($CR)['username']?></small>
                    <!--make small label telling the user which username corresponds to the ID, if the page is 'update'-->
                <?php endif;?>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputCG'>Category:</label>

                <?php switch($CG):
                    case('meta'):?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta' selected>Meta</option>
                            <option value='general'>General</option>
                            <option value='support'>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    <?php break;

                    case('general'):?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta'>Meta</option>
                            <option value='general' selected>General</option>
                            <option value='support'>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    <?php break;

                    case('support'):?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta'>Meta</option>
                            <option value='general'>General</option>
                            <option value='support' selected>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    <?php break;

                    case('news'):?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta'>Meta</option>
                            <option value='general'>General</option>
                            <option value='support'>Support</option>
                            <option value='news' selected>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    <?php break;

                    case('hobbies'):?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta'>Meta</option>
                            <option value='general'>General</option>
                            <option value='support'>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies' selected>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    <?php break;

                    case('debate'):?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta'>Meta</option>
                            <option value='general'>General</option>
                            <option value='support'>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate' selected>Debate</option>
                        </select>
                    <?php break;

                    default:?>
                        <select name='inputCG' class='form-control'>
                            <option value='meta'>Meta</option>
                            <option value='general' selected>General</option>
                            <option value='support'>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    <?php break;
                endswitch;?>
                <!--switch for making the right value selected in the dropdown depending on which is in the record-->
                
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputCD'>Created on:</label>
                <input type='date' name='inputCD' value='<?=$CD?>' class='form-control' required>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputPD'>Pinned?</label>
                <?php if($PD == 1):?>
                    <input type='checkbox' name='inputPD' value='1' class='form-control col-sm-2' checked>
                <?php else:?>
                    <input type='checkbox' name='inputPD' value='1' class='form-control col-sm-2'>
                <?php endif;?>
            </div>

            <!--if statements for checkbox display-->

            <div class='form-group'>
                <label class='control-label' for='inputOR'>Open to replies?</label>
                <?php if($OR == 1):?>
                    <input type='checkbox' name='inputOR' value='1' class='form-control col-sm-2' checked>
                <?php else:?>
                    <input type='checkbox' name='inputOR' value='1' class='form-control col-sm-2'>
                <?php endif;?>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputAR'>Length of thread:</label>
                <table style='width:100%;margin:0;padding:0;'>
                    <tr>
                        <td><input type='number' name='inputAR' value='<?=$AR?>' class='form-control' style='text-align:right;' required></td><td>&nbsp;post(s)</td>
                    </tr>
                </table>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputLP'>Last reply:</label>
                <input type='date' name='inputLP' value='<?=$LP?>' class='form-control' required>
            </div>

            <button type='submit' class='btn btn-outline-success mb-3'>Submit</button>


        </form>

            <div style='width:50%; height:50%; overflow-y:scroll;' class='mb-5 border rounded border-dark'>
                <h3 style='text-align:center;' class=''>Valid User IDs</h3>
                <table class='table table-striped'>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                    </tr>
                    <?php foreach(getValidIDs('forum_users') as $row):?>
                        <tr>
                            <td><?=$row['userID']?></td>
                            <td><?=$row['username']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <!--display a small table with all valid UserIDs for better user experience-->

        <?php include_once 'includes\footer.php';?>

    </div>

    <script>
        var badUID = document.querySelector('#badUID').getAttribute('value')
        console.log(badUID)
        if(badUID == 1){
            alert("Creator's ID number does not match an existing user. Please enter a valid ID. For list of valid IDs, check the View & Search page for the Users table.")
        }
    </script>

<!-- 
!!!!!-----------------------------------------------------------------------------------------------------------------------------------------------------!!!!!
  check AUbridge.php for full documentation! the two pages work almost exactly the same but for different tables. differences will be touched upon here though.
!!!!!-----------------------------------------------------------------------------------------------------------------------------------------------------!!!!! 
-->


</body>
</html>