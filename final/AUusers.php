<?php

include_once 'includes/header.php';
include_once __DIR__ . '/model/db_functions.php';
include_once __DIR__ . '/includes/postcheck.php';

if(isset($_GET['action'])){
    $action = filter_input(INPUT_GET, 'action');
    $id = filter_input(INPUT_GET, 'userID');

    if($action == 'update'){
        $row = getARecord($id, 'forum_users');
        $UN = $row
    }

   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body{
            margin:0;
            padding:0;
        }
        body{
            background-image: url("images/background.png")
        }
        #cont{
            width: 75%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            background-color:white;
            overflow-y:scroll;
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

        <h1 class='my-2'>Add & Update - Users</h1>

        <form action='AUusers.php' method='post' style='text-align:left;width:50%;' class='form-horizontal'>

            <div class='form-group'>
                <label class='control-label' for='inputUN'>Username:</label>
                <input type='text' name='inputUN' class='form-control'>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputPW'>Password:</label>
                <input type='text' name='inputPW' class='form-control'>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputEM'>Email:</label>
                <input type='email' nanme='inputEM' class='form-control'>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputVE'>Email verified?</label>
                <input type='checkbox' name='inputVE' class='form-control col-sm-2'>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputBD'>Birthday:</label>
                <input type='date' name='inputBD' class='form-control'>
            </div>

            <div class='form-group'>
                <label class='control-label' for='inputDJ'>Date joined:</label>    
                <input type='date' name='inputDJ' class='form-control'>
            </div>

            <div class='form-group'> 
                <label class='control-label' for='inputRK'>Rank:</label>   
                <input type='number' name='inputRK' class='form-control' disabled value='0'>
            </div>

            <div class='form-group'>  
                <label class='control-label' for='inputPA'>Amt. of Posts:</label>  
                <input type='number' name='inputPA' class='form-control' disabled value='0'>
            </div>

            <div class='form-group'>  
                <label class='control-label' for='inputPV'>Privilege level:</label>  
                <select name='inputPV' class='form-control'>
                    <option value='owner'>Owner</option>
                </select>
            </div>

            <button type='submit' class='btn btn-outline-success'>Submit</button>
        </form>

    </div>

    <?php include_once 'includes/footer.php';?>

</body>
</html>