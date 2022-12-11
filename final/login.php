<?php

include_once __DIR__ . '/includes/postcheck.php';
include_once __DIR__ . '/model/db_functions.php';

session_start();

if(isPostRequest()){
    $username = filter_input(INPUT_POST, 'inputUN');
    $password = filter_input(INPUT_POST, 'inputPW');

    $search = getALogin($username);

    if($search != "No user with that name found."){
        $salt = $search['salt'];
        $enc = $search['encPass'];

        if(sha1($password.$salt) == $enc){
            $_SESSION['username'] = $username;
            $_SESSION['loggedIn'] = TRUE;

            header('Location: index.php');
        } else {
            $_SESSION['loggedIn'] = FALSE;
        }
    } else {
        $_SESSION['loggedIn'] = FALSE;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forums Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        html, body{
            margin:0;
            height:100%;
        }
        body, .container{
            display:flex;
            justify-content:center;
            align-items:center;
        }
        body{
            background-image: url("images/background.png")
        }
        #loginBox{
            margin:auto;
            width:30%;
            background-color:white;
        }
    </style>
</head>
<body>
    
    <div id="loginBox" class='p-2'>

        <?php if(isPostRequest()):?>
            <?php if(!$_SESSION['loggedIn']):?>
                <div class='alert alert-danger mt-2' role='alert'>The username was not found, or the password was incorrect.</div>
            <?php endif;?>
        <?php endif;?>

        <h3 class='my-3'>Login</h3>

        <form method='post' action='login.php'>
            <div class='mb-3'>
                <label for='inputUN' class='form-label'>Username</label>
                <input type='text' class='form-control' id='inputUN' name='inputUN'>
            </div>
            <div class='mb-3'>
                <label for='inputPW' class='form-label'>Password</label>
                <input type='password' class='form-control' id='inputPW' name='inputPW'>
            </div>
            <button type='submit' class='btn btn-outline-primary'>Go</button>
        </form>

    </div>

</body>
</html>