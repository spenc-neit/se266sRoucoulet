<?php
    session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn'])){ //if loggedIn is false or blank (if user is not logged in)
        header('Location: login.php'); 
        //redirect to login 
        //this will run in every page the header is in
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forums Database</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        #t{
            font-size:2.5rem;
        }
        .nav-link{
            font-size:1.5rem;
        }
    </style>
    <link rel='stylesheet' href='includes/styles.css'>
</head>
<body>


<nav class="navbar navbar-expand-lg justify-content-between navbar-dark bg-dark px-3" id='header'>

    <a class="navbar-brand mb-0 h1 fs-2.5" id='t' href='index.php'><b>Forums</b></a>

    <div class='nav-item dropdown border border-light rounded'>
        <a class='nav-link dropdown-toggle text-light' href="#" role='button' id='usersDropdown' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Users Table
        </a>
        <div class='dropdown-menu' aria-labelledby='usersDropdown'>
            <a class='dropdown-item' href='VSDusers.php'>View & Search</a>
            <a class='dropdown-item' href='AUusers.php?action=add'>Add</a>
        </div>
    </div>

    <div class='nav-item dropdown border border-light rounded'>
        <a class='nav-link dropdown-toggle text-light' href="#" role='button' id='bridgeDropdown' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Bridge Table
        </a>
        <div class='dropdown-menu' aria-labelledby='bridgeDropdown'>
            <a class='dropdown-item' href='VSDbridge.php'>View & Search</a>
            <a class='dropdown-item' href='AUbridge.php?action=add'>Add</a>
        </div>
    </div>

    <div class='nav-item dropdown border border-light rounded'>
        <a class='nav-link dropdown-toggle text-light' href="#" role='button' id='forumsDropdown' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            Forums Table
        </a>
        <div class='dropdown-menu' aria-labelledby='forumsDropdown'>
            <a class='dropdown-item' href='VSDforums.php'>View & Search</a>
            <a class='dropdown-item' href='AUforums.php?action=add'>Add</a>
        </div>
    </div>

    <a href="logout.php" class="btn btn-outline-danger nav-item">Logout</a>

</nav>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
