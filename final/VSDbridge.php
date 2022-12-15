<?php

include_once 'includes\header.php';//header contains navbar, login check, and session start
include 'model\db_functions.php';
include 'includes\postcheck.php';

$searchUID = "";
$searchFID = "";
//init empty search values

$deleted = 0;
//init empty bool to tell JS if a record was deleted (so it knows whether or not to display an alert)

if(isPostRequest()){ //if POST
    $searchUID = filter_input(INPUT_POST, 'inputUID');
    $searchFID = filter_input(INPUT_POST, 'inputFID');
    //grab the values the user sent in from POST and put in vars

    if(isset($_POST['bridgeID'])){ //if there is a specific ID sent in
        //this will only happen when the user clicks the trash icon to delete a record
        $id = filter_input(INPUT_POST, 'bridgeID'); //grab ID
        deleteRecord($id, 'bridge'); //delete the user corresponding to the ID, specifying the right table
        $deleted = 1; //confirm the record was deleted to the JS
    }
}

$bridges = getBridges($searchUID, $searchFID); //search for records matching the search criteria passed in from the POST form

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
        <!--hidden input to keep track of the deleted bool for the JS to grab and check-->

        <h1 class='my-2'>View & Search - Bridge</h1>
        <h4 class='mb-2'>The point of this table is to catalog which users are part of which forums.</h3>

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
        <!--search bar form-->

        <p><?=count($bridges)?> matching bridge records were found.</p>
        <!--little p tag to say how many records were found matching search criteria-->

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
                    <td><?=getUsername($row['userID'])['username']?></td><!--a cell saying which username the relevant ID belongs to for better user-friendliness-->
                    <td><?=$row['userID']?></td>
                    <td><?=$row['forumID']?></td>
                    <td><?=getTitle($row['forumID'])['title']?></td><!--a cell saying which forum title the relevant ID belongs to for better user-friendliness-->
                    <td>
                        <button onclick="window.location.href='AUbridge.php?action=update&bridgeID=<?=$row['bridgeID']?>';" class='btn'>✎</button>
                        <form action="VSDbridge.php" method="post">
                            <input type="hidden" name="bridgeID" value="<?= $row['bridgeID'] ?>" />
                            <button class="btn" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach;?>
            <!--loop through the records found in the search and display them as table rows, along with buttons to edit or delete each record-->
        </table>
                


    <?php include_once 'includes\footer.php';?>

    <script>
        var delCheck = document.querySelector('#deleted').getAttribute('value')
        if(delCheck == 1){
            alert("Record was deleted.")
        }//if a record was deleted send an alert confirming this in JS
    </script>

</body>
</html>