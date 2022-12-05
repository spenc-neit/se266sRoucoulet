<?php
    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn'])){ //if loggedIn is false or blank (if user is not logged in)
        header('Location: login.php'); 
        //redirect to login 
    //this will run in every page the header is in
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Schools upload and search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        #t{
            font-size:2.5rem;
        }
        .nav-link{
            font-size:1.5rem;
        }
    </style>
</head>
<body>

<div class='container px-0'>
<nav class="navbar justify-content-between navbar-dark bg-dark px-3">
    <span class="navbar-brand mb-0 h1 fs-2.5" id='t'>Schools</span>
    <a href='schoolUpload.php' class='nav-link text-light'>Upload</a>
    <a href='schoolSearch.php' class='nav-link text-light'>Search</a>
    <a href="logout.php" class="btn btn-outline-danger nav-item">Logout</a>
</nav>
</div>