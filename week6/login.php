<?php 
include_once __DIR__ . 'postcheck.php';

session_start();

if(isPostRequest()){
    $username = filter_input($_POST, 'inputUN');
    $password = filter_input($_POST, 'inputPW');

    

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>

<div style='margin:auto;width:50%;'>
    <h3 class='my-3'>Login</h3>

    <form method='post' action='login.php'>
        <div class="mb-3">
            <label for="inputUN" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUN">
        </div>
        <div class="mb-3">
            <label for="inputPW" class="form-label">Password</label>
            <input type="text" class="form-control" id="inputPW">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>



</body>
</html>