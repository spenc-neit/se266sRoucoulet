<?php include "index.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Intake Form</title>
    <style>
        .err{
            color:red;
        }
    </style>
</head>
<body>
    
<h1>Patient Intake Form</h1>
<h3>--Healthy Living Clinic--</h3>


<form method="post" action="indexfront.php">



    <table>
        <tbody>
            <tr>
                <td style="text-align:right;">Name:</td>
                <td><input type="text" name="fname" placeholder="First name" value="<?= $fnameInput ?>" /> <input type="text" name="lname" placeholder="Last name" value="<?= $lnameInput ?>" /></td>
                <!--use variables for input value to make the user's input stick when submitting form-->
            </tr>

            <?php if ($marriedInput == "yes"): ?>

                <tr>
                    <td style="text-align:right;">Married:</td>
                    <td><input type="radio" name="married" value="yes" checked>Yes <input type="radio" name="married" value="no">No</td>
                </tr>

            <?php elseif ($marriedInput == "no"): ?>

                <tr>
                    <td style="text-align:right;">Married:</td>
                    <td><input type="radio" name="married" value="yes">Yes <input type="radio" name="married" value="no" checked>No</td>
                </tr>

            <?php else: ?>

                <tr>
                    <td style="text-align:right;">Married:</td>
                    <td><input type="radio" name="married" value="yes">Yes <input type="radio" name="married" value="no">No</td>
                </tr>

            <?php endif; ?>
            <!--use an if/ifelse/else loop to check the value of $marriedinput to know which option (if any) to select after the form gets submitted-->
            
            <tr>
                <td style="text-align:right;">Date of birth:</td>
                <td><input type="date" name="dob" value="<?= $dobInput ?>" ></td>
            </tr>

            <tr>
                <td style="text-align:right;">Weight:</td>
                <td><input type="text" name="weight" value="<?= $weightInput ?>" /> lbs</td>
            </tr>
            
            <tr>
                <td style="text-align:right;">Height:</td>
                <td><input type="text" name="fheight" value="<?= $fheightInput ?>" /> feet <input type="text" name="iheight" value="<?= $iheightInput ?>" /> inches</td>
            </tr>
            
            <tr>
                <td><input type="submit" name="submitbtn" /></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</form>

<p><a href="https://github.com/spenc-neit/se266sRoucoulet">Github Repository</a></p>

</body>
</html>