<?php 

include_once __DIR__ . '/postcheck.php';
    //include data model file
include_once __DIR__ . '/models/mdl_schools.php';
    //include file w/ function to check for POST method


session_start(); //start session

$_SESSION['uploaded'] = FALSE;
//set session var (for checking if the upload process is done) to false


if(isPostRequest()){ //if there is a post request

    $username = filter_input(INPUT_POST, 'inputUN'); 
        //take user's inputted username from POST
    $password = filter_input(INPUT_POST, 'inputPW'); 
        //take user's inputted password from POST
    
    $search = getAUser($username); 
        //find the user information that corresponds to the inputted username

    if ($search != "No user with that name found."){ //if the search did not come up empty
        $salt = $search['salt'];
            //store the user's salt value
        $enc = $search['encPass']; 
            //store the user's encrypted password + salt

        if(sha1($password.$salt) == $enc){ //if the entered password + salt, when run through sha1, equals the stored encrypted password
            $_SESSION['username'] = $username; 
                //store the username in session
            $_SESSION['loggedIn'] = TRUE; 
                //store a value clarifying that the user IS logged in
            
            header('Location: schoolUpload.php'); 
                //redirect to index

        } else { //if the entered password + salt, when run through sha1, does not equal the stored encrypted pw+salt
            $_SESSION['loggedIn'] = FALSE; 
                //set a value clarifying the user is NOT logged in
        }

    } else { 
        $_SESSION['loggedIn'] = FALSE;
            //set a value clarifying the user is NOT logged in
    }
    
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

    <?php if(isPostRequest()):?> <!-- if the page has a post request -->
        <?php if(!$_SESSION['loggedIn']):?> <!-- if the user is explicitly not logged in when the page loads -->
            <div class="alert alert-danger mt-2" role="alert">The username was not found, or the password was incorrect.</div> <!-- display error message -->
        <?php endif;?>
    <?php endif;?>

    <h3 class='my-3'>Login</h3>

    <form method='post' action='login.php'>
        <div class="mb-3">
            <label for="inputUN" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUN" name='inputUN'>
        </div>
        <div class="mb-3">
            <label for="inputPW" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPW" name='inputPW'>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include 'footer.php'; ?> <!--display footer-->

</body>
</html>