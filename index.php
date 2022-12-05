<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE266 Home Page - SDR</title>
</head>
<body>
    <h1>Spencer Roucoulet</h1>
    <h3><a href="https://github.com/spenc-neit/se266sRoucoulet">Github Repository</a></h3>
    
    <h3>Resources to learn Git:</h3>
    <ul>
        <li><a href="https://www.atlassian.com/git">Atlassian Bitbucket</a></li>
        <li><a href="https://learngitbranching.js.org/?locale=en_US">Learn Git Branching</a></li>
        <li><a href="https://www.codecademy.com/learn/learn-git">Code Academy</a></li>
    </ul>
    
    <h3>Resources to learn PHP:</h3>
    <ul>
        <li><a href="https://www.w3schools.com/php/">W3 Schools</a></li>
        <li><a href="https://www.codecademy.com/learn/learn-php">Code Academy</a></li>
        <li><a href="https://www.learn-php.org">learn-php.org</a></li>
    </ul>

    <h3>Other Hobbies:</h3>
    <ul>
        <li><a href="https://fallout.bethesda.net/en/">Fallout 76</a></li>
        <li>Making side/personal projects in JavaScript</li>
        <li>Reading and writing</li>
    </ul>

    <h3>Links to Active Assignments</h3>
    <ul>
        <li><a href="week1/">Week 1 - Mini Tasks C-G</a></li>
        <li><a href="week2/b/indexfront.php">Week 2 - Patient Intake Form</a></li>
        <li><a href="week3/atm_starter.php">Week 3 - ATM Simulation</a></li>
        <li><a href="week4">Week 4 - Patient CRUD</a></li>
        <li><a href="week6/login.php">Week 6 - Patient Search & Sessions</a></li>
        <li><a href="week7/login.php">Week 7 - Schools Upload & Search</a></li>
        <li><a href="#">Week 8</a></li>
    </ul>
    <hr />
    <footer>
    <?php       
        date_default_timezone_set("America/New_York");
        $file = basename($_SERVER['PHP_SELF']);
        $mod_date=date("F d Y h:i:s A", filemtime($file));
        $test = new DateTime($mod_date, new DateTimeZone('America/New_York'));
        echo "File last updated " . date_format($test, "F d Y h:i:s A");
    ?>
    </footer>

</body>
</html>