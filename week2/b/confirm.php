<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Page</title>
</head>
<body>
    <h1>Patient Intake Form</h1>
    <h3>--Healthy Living Clinic--</h3>
    <dl>
        <dt>Name:</dt>
        <dd><?= $fnameInput . $lnameInput ?></dd>
        <dt>Married:</dt>
        <dd><?= $marriedInput ?></dd>
        <dt>Date of Birth:</dt>
        <dd><?= $dobInput ?></dd>
        <dt>Weight:</dt>
        <dd><?= $weightInput ?></dd>
        <dt>Height:</dt>
        <dd><?= $fheightInput . `' ` . $iheightInput . `"` ?></dd>
        <dt>BMI:</dt>
        <dd><?= $bmi . " - " . $classification ?></dd>
    </dl>
</body>
</html>