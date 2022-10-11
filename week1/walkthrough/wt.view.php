<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        header{
            background-color:grey;
            padding: 2em;
            text-align:center;
        }
        h1{
            border:1px solid black;
        }
    </style>
</head>

<body>

    <ul>
        <?php foreach ($person as $desc => $value) : ?>
            <li><?= "<b>{$desc}:</b> " . $value; ?>
        <?php endforeach; ?>
    </ul>

    <?= '<p>full array:</p>' ?>

    <?= '<pre>'; ?>
    <?= var_dump($person); ?>
    <?= '</pre>'; ?>

</body>

</html>