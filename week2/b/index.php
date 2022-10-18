<?php


if(isset($_POST['submitbtn']) !== ""){
    
    


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Intake Form</title>
</head>
<body>
<h1>Patient Intake Form</h1>
<h3>--Healthy Living Clinic--</h3>

<form method="post" action="index.php">
    Name: <input type="text" name="fname" placeholder="First name" />
    <input type="text" name="lname" placeholder="Last name" /><br />
    Married <input type="checkbox" name="status"><br />
    Date of birth: <input type="date" name="dob"><br />
    Weight: <input type="text" name="weight" /> lbs<br />
    Height: <input type="text" name="fheight" /> feet
    <input type="text" name="iheight" /> inches<br />
    <input type="submit" name="submitbtn" />
</form>

</body>
</html>