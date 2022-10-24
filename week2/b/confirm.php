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
        <dt><b>Name:</b></dt>
        <dd><?= $fnameInput . " " . $lnameInput ?></dd>
        <dt><b>Married:</b></dt>
        <dd><?= $marriedInput ?></dd>
        <dt><b>Date of Birth:</b></dt>
        <dd><?= $dobInput ?></dd>
        <dt><b>Weight:</b></dt>
        <dd><?= $weightInput ?></dd>
        <dt><b>Height:</b></dt>
        <dd><?= $fheightInput . `' ` . $iheightInput . `"` ?></dd>
        <dt><b>BMI:</b></dt>
        <dd><?= $bmi . " - " . $classification ?></dd>
    </dl>
</body>
</html>