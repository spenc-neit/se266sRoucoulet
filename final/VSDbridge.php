<?php

include_once __DIR__ . '/includes/header.php';
include __DIR__ . '/model/db_functions.php';
include __DIR__ . '/includes/postcheck.php';

$searchUID = "";
$searchFID = "";

$deleted = 0;

if(isPostRequest()){
    $searchUID = filter_input(INPUT_POST, 'inputUID');
    $searcHFID = filter_input(INPUT_POST, 'inputFID');

    if(isset($_POST['bridgeID'])){
        $id = filter_input(INPUT_POST, 'bridgeID');
        deleteRecord($id, 'bridge');
        $deleted = 1;
    }
}

$bridges = getBridges($searchUID, $searchFID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
        var header = document.querySelector('#header')
        var headerHeight = header.offsetHeight
        var body = document.querySelector('body')
        var html = document.querySelector('html')
        html.style.height = "100%"
        var htmlHeight = html.offsetHeight
        var newHeight = htmlHeight - headerHeight
        html.style.height = String(newHeight + 'px')
        body.style.height = String(newHeight + 'px')
    </script>
</head>
<body>
    
    <div class='h-100' id='cont'>
        <input type='hidden' id='deleted' value='<?=$deleted?>'></input>

        <h1 class='my-2'>View & Search - Bridge</h1>
        <h4 class='mb-2'>The point of this table is to show which users are part of which forum.</h3>

        <form action='VSDbridge.php' method='post'>
            <table style='width:100%;'>
                <tr>
                    <td><label for='inputUID'>User ID</label></td>
                    <td><label for='inputFID'>Forum ID</label></td>
                </tr>
                <tr>
                    <td><input class='form-control' type='number' name='inputUID' id='inputUID'></td>
                    <td><input class='form-control' type='number' name='inputFID' id='inputFID'></td>
                </tr>
                <tr>
                    <td><button class='btn btn-outline-success my-2' type='submit'>Search</button></td>
                </tr>
            </table>
        </form>

        <p><?=count($bridges)?> matching bridge records were found.</p>

        <table class='table table-striped'>
            <tr>
                <th>Bridge ID</th>
                <th>Username</th>
                <th>User ID</th>
                <th>Forum ID</th>
                <th>Forum Title</th>
                <th></th>
            </tr>

            <?php foreach($bridges as $row):?>
                <tr>
                    <td><?=$row['bridgeID']?></td>
                    <td><?=getUsername($row['userID'])['username']?></td>
                    <td><?=$row['userID']?></td>
                    <td><?=$row['forumID']?></td>
                    <td><?=getTitle($row['forumID'])['title']?></td>
                    <td>
                        <button onclick="window.location.href='AUbridge.php?action=update&bridgeID=<?=$row['bridgeID']?>';" class='btn'>✎</button>
                        <form action="VSDbridge.php" method="post">
                            <input type="hidden" name="bridgeID" value="<?= $row['bridgeID'] ?>" />
                            <button class="btn" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
                


    <?php include_once 'includes/footer.php';?>

    <script>
        var delCheck = document.querySelector('#deleted').getAttribute('value')
        if(delCheck == 1){
            alert("Record was deleted.")
        }
    </script>

</body>
</html>