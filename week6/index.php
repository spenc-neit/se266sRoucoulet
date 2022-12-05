<?php
session_start(); //open session

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn'])){ //if loggedIn is false or blank (if user is not logged in)
        header('Location: login.php'); 
        //redirect to login 
    }

    include __DIR__ . '/models/mdl_patients.php';
    //include data model file
    include __DIR__ . '/postcheck.php';
    //include file w/ function to check for POST method

    $searchFirst = "";
    $searchLast = "";
    $searchMar = "";
    //define empty search variables in case the user does not enter anything in the search inputs



    if(isPostRequest()){ //if the page is POST

        $searchFirst = filter_input(INPUT_POST, 'fNameInput');
        $searchLast = filter_input(INPUT_POST, 'lNameInput');
        $searchMar = filter_input(INPUT_POST, 'marInput');
        //fill search variables with entered values (blank will just stay blank if the user doesn't enter values into a field)
        
        
        if(isset($_POST['patientID'])){ //if the POST contains a user ID (this will only happen when the user clicks a delete button)
            $id = filter_input(INPUT_POST, 'patientID');
                //grab ID passed in POST
            deletePatient($id);
                //delete the record with the ID given in POST
        }

    }

    $patients = getPatients($searchFirst, $searchLast, $searchMar);
    //fetch all records in the table that fit search criteria and store in var
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="col-sm-offset-2 col-sm-10">
            <h1>Patients</h1>

            <table>
                <tr>
                    <form method='post' action='index.php'>
                        <td><input type="text" placeholder="First name" name="fNameInput"></td>
                        <td><input type="text" placeholder="Last name" name="lNameInput"></td>
                        <td>Married? <input type="radio" name="marInput" value="1">Yes <input type="radio" name="marInput" value="0">No&nbsp;&nbsp;</td>
                        <td><button type="submit">Search</button>
                    </form>
                </tr>
            </table>

            <br />

            <table class='table table-striped'>

                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Married?</th>
                    <th>Birthday</th>
                    <th>Edit</th>
                    <th></th>
                </tr>

                <?php foreach ($patients as $row): ?> <!--for every row in patients-->
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['patientFirstName'] ?></td>
                        <td><?= $row['patientLastName'] ?></td>
                        <td>
                            <?php if($row['patientMarried'] == 1): ?>
                                Yes
                            <?php else: ?>
                                No
                            <?php endif; ?> 
                        </td>
                        <td><?= $row['patientBirthDate'] ?></td>
                        <!--fetch attributes of row and display on page in proper place in table
                            married needs an if/else to display 'no' or 'yes' because '0' and '1' could be confusing values for people who don't understand boolean or know to interpret it as boolean-->

                        <td><a href='addPatient.php?action=update&patientID=<?=$row['id']?>'>Edit</a></td>
                        <!--add an edit button, with a link to the add/edit page containing the action (update) and the current row's ID-->
                        <td>
                            <form action="index.php" method="post">
                                <input type="hidden" name="patientID" value="<?= $row['id'] ?>" />
                                <button class="btn glyphicon glyphicon-trash" type="submit">🗑️</button>
                            </form>
                        </td>
                        <!--create a mini form that sends its values to index.php when submitted
                        it contains a delete (submit) button and a hidden input containing the current row's ID to send in the POST data so that index knows what to delete-->
                    </tr>
                <?php endforeach; ?>
                </table>

            <br />
            <a href="addPatient.php?action=add" class="btn btn-secondary">Add Patient</a> <!--link to access the add patient page, sending the action (add) as well-->
            <br /><br />
            <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        </div>

    </div>
</body>
</html>