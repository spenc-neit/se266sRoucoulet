<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Task D</title>
</head>
<body>
    
    <h1><strong>YOUR TASK:</strong></h1> <!--header-->
    
    <ul>

        <li><b>Description: </b>
            <?= $task['title']; ?>
        </li>

        <li><b>Budget: </b>
            <?= '$' . $task['budget']; ?>
        </li>

        <li><b>Deadline: </b>
            <?= $task['deadline']; ?>
        </li>

        <li><b>Theme: </b>
            <?= $task['theme']; ?>
        </li>

        <li><b>Completed: </b>
            <?=  $task['completed'] ? '☑' : '☐';?>
        </li>

        <!-- go through each key/value manually, using a condition for 'completed' to decide whether to display a filled or unfilled ballot box -->

    </ul>
    
</body>
</html>