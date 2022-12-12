<?php
    include __DIR__ . '/models/mdl_patients.php';
    //include data model file
    include __DIR__ . '/postcheck.php';
    //include file with function to check for POST method

    echo '<pre style="background-color:white;">';
echo 'post';
var_dump($_POST);
echo 'get';
var_dump($_GET);
echo '</pre>';

    session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn'])){ //if loggedIn is false or blank (if user is not logged in)
        header('Location: login.php'); //redirect to login page
    }

    if(isset($_GET['action'])) { //if GET has a value with the 'action' key

        $action = filter_input(INPUT_GET, 'action');
        $id = filter_input(INPUT_GET, 'patientID');
        //set the action and id variables, with the values that are in the GET data
            //the only scenario that this page is GET is one that also includes proper data for these variables to hold

        if ($action == "update"){ //if the sent action was 'update'

            $row = getAPatient($id); //retrieve a record, where the record's ID is the one sent in the GET data
            $fName = $row['patientFirstName'];
            $lName = $row['patientLastName'];
            $mar = $row['patientMarried'];
            $dob = $row['patientBirthDate'];
            //fill corresponding variables with the values of this record

        }else{ //if the action is not update (aka when the user is ADDING a record)

            $fName = '';
            $lName = '';
            $mar = '';
            $dob = '';
            //fill the aforementioned variables with empty strings so that the PHP in the HTML has values to call
        }
    } elseif (isset($_POST['action'])) { //if GET does not have a value with the 'action' key but POST does

        $action = filter_input(INPUT_POST, 'action');
        $id = filter_input(INPUT_POST, 'patientID');
        $fName = filter_input(INPUT_POST, 'patientFirstName');
        $lName = filter_input(INPUT_POST, 'patientLastName');
        $mar = filter_input(INPUT_POST, 'patientMarried', FILTER_VALIDATE_BOOLEAN);
        $dob = filter_input(INPUT_POST, 'patientBirthDate');
        //fill everything in according to the values pulled from the POST data
    }
    
    
    if (isPostRequest() AND $action == 'add'){ //if the page is POST and the sent action is 'add'

        $result = addPatient($fName, $lName, $mar, $dob); 
        //add a record with the values already added from the PHP at the top of the page
        header('Location: index.php'); 
        //redirect to index

    } elseif (isPostRequest() AND $action == 'update'){ //if the page is POST and the sent action is 'update'

        $result = updatePatient($id, $fName, $lName, $mar, $dob); 
        //update the record with the ID and values already added from the PHP at the top of the page
        header('Location: index.php');
        //redirect to index
    }

    if(empty($_GET) AND empty($_POST)){ //if both GET and POST are empty

        $fName = '';
        $lName = '';
        $mar = '';
        $dob = '';
        $action = '';
        //fill in these values with empty strings
            //this should never come up. it's here because the link being accessed directly without any info passed via forms (aka how the page appears during testing) breaks it
                //using the website starting from the homepage *should* give no way to access the page in this way, so I probably could have left this out but I didn't want to leave an error in here
                //at least now people can copy/paste the bare link without it breaking... in the *highly* unlikely event that that *ever* happens
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<div class='container'>


    <?php if (($action == 'add') OR (empty($_GET) AND empty($_POST))):?> <!--if the passed action is 'add' or *both* GET and POST are empty (see above 4-line comment)-->
        <h2>Add Patient</h2>
    <?php elseif($action == 'update'):?> <!--if the passed action is 'update'-->
        <h2>Update Patient Information</h2>
    <?php endif;?>

    <form class="form-horizontal" action = 'addPatient.php' method='post'>
        <input type='hidden' name='action' value='<?= $action ?>'>
        <input type='hidden' name='patientID' value='<?= $id ?>'>
        <!-- hidden inputs to pass these important values through GET/POST -->

        <div class="form-group">
            <label class='control-label col-sm-2' for='patientFirstName'>First name:</label>
            <div class='col-sm-10'>
                <input type='text' class='form-control' id='patientFirstName' placeholder="Enter patient's first name" name='patientFirstName' value='<?= $fName ?>' required>
            </div>
        </div>

        <div class="form-group">
            <label class='control-label col-sm-2' for='patientLastName'>Last name:</label>
            <div class='col-sm-10'>
                <input type='text' class='form-control' id='patientLastName' placeholder="Enter patient's last name" name='patientLastName' value='<?= $lName ?>' required>
            </div>
        </div>

        <div class="form-group">
            <label class='control-label col-sm-2' for='patientMarried'>Married?</label>
            <div class='col-sm-10'>

            <?php if ($mar == 1): ?>
                <input type="radio" name="patientMarried" value="1" checked>Yes <input type="radio" name="patientMarried" value="0">No
            <?php elseif($mar == 0): ?>
                <input type="radio" name="patientMarried" value="1">Yes <input type="radio" name="patientMarried" value="0" checked>No
            <?php else:?>
                <input type="radio" name="patientMarried" value="1">Yes <input type="radio" name="patientMarried" value="0">No
            <?php endif;?>
            <!-- if/elseif/else for sticking radio input values - the only difference between the three different outputs are which radio, if either, are checked -->

            </div>
        </div>

        <div class="form-group">
            <label class='control-label col-sm-2' for='patientBirthDate'>Date of birth:</label>
            <div class='col-sm-10'>
                <input type="date" name="patientBirthDate" value='<?= $dob ?>' required>
            </div>
        </div>

        <br />

        <div class='form-group'>
            <div class='col-sm-offset-2 col-sm-10'>
                <button type='submit' class='btn btn-primary'>Submit</button>
                <?php
                    if(isPostRequest()){ //if the page is POST (aka if the user adds a patient, since that's the only scenario that the page is remained on after POST is submitted)
                        echo "Patient added";
                    }
                ?>
            </div>
        </div>
    </form>

    <br /><br />
    <a href='./index.php' class='btn btn-default'>View Patients</a> <!--link to return to the homepage-->
</div>
</body>
</html>