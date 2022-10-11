<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Task D</title>
</head>
<body>

    <ul>

        <h1><strong>YOUR TASK:</strong></h1> <!--header-->

        <?php foreach ($task as $desc => $value) : ?>
            <li><?= "<b>{$desc}</b>: " . $value; ?>
        <?php endforeach; ?>

        <!-- loop through AA, returning both key and value substituted into an <li> to be placed into a <ul> -->

    </ul>
    
</body>
</html>