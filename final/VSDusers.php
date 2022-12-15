<?php

//!!!!!------------------------------------------------------------------------------------------------------------------------------------------------------!!!!!
//  check VSDbridge.php for full documentation! the two pages work almost exactly the same but for different tables. differences will be touched upon here though.
//!!!!!------------------------------------------------------------------------------------------------------------------------------------------------------!!!!!

include_once 'includes\header.php';
include 'model\db_functions.php';
include 'includes\postcheck.php';

$searchUsername = "";
$searchEmail = "";
$searchPriv = "";

$deleted = 0;

if(isPostRequest()){
    $searchUsername = filter_input(INPUT_POST, 'inputUsername');
    $searchEmail = filter_input(INPUT_POST, 'inputEmail');
    $searchPriv = filter_input(INPUT_POST, 'inputPriv');

    if(isset($_POST['userID'])){
        $id = filter_input(INPUT_POST, 'userID');
        deleteRecord($id, 'forum_users');
        $deleted = 1;
    }
}

$users = getForumUsers($searchUsername, $searchEmail, $searchPriv);

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

        <h1 class='my-2'>View & Search - Users</h1>

        <form action='VSDusers.php' method='post'>
            <table style='width:100%;'>
                <tr>
                    <td><label for='inputUsername'>Username</label></td>
                    <td><label for='inputEmail'>Email</label></td>
                    <td><label for='inputPriv'>Privilege level</label></td>
                </tr>
                <tr>
                    <td><input class='form-control' type='text' name='inputUsername' id='inputUsername'></td>
                    <td><input class='form-control' type='text' name='inputEmail' id='inputEmail'></td>
                    <td>
                        <select class='form-control' name='inputPriv' id='inputPriv'>
                            <option value=''></option>
                            <option value='owner'>Owner</option>
                            <option value='default'>Default</option>
                            <option value='moderator'>Moderator</option>
                            <option value='admin'>Administrator</option>
                            <option value='banned'>Banned</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><button class='btn btn-outline-success my-2' type='submit'>Search</button></td>
                </tr>
            </table>
        </form>

        <p><?=count($users)?> matching users found.</p>

        <table class='table table-striped'>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Email verified?</th>
                <th>Birthday</th>
                <th>Date joined</th>
                <th>Rank</th>
                <th>Amt. of posts</th>
                <th>Privilege level</th>
                <th></th>
            </tr>

            <?php foreach ($users as $row):?>
                <tr>
                    <td><?=$row['userID']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['pass']?></td>
                    <td><?=$row['email']?></td>
                    <td>
                        <?php if($row['verified'] == 1): ?>
                            Yes
                        <?php else: ?>
                            No
                        <?php endif; ?> 
                    </td>
                    <td><?=$row['birthday']?></td>
                    <td><?=$row['joined']?></td>
                    <td><?=$row['userRank']?></td>
                    <td><?=$row['amtPosts']?></td>
                    <td><?=$row['privilege']?></td>
                    <td>
                    <button onclick="window.location.href='AUusers.php?action=update&userID=<?=$row['userID']?>';" class='btn'>✎</button>
                        <form action="VSDusers.php" method="post">
                            <input type="hidden" name="userID" value="<?= $row['userID'] ?>" />
                            <button class="btn" type="submit">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>

    </div>

    <?php include_once 'includes\footer.php';?>

    <script>
        var delCheck = document.querySelector('#deleted').getAttribute('value')
        if(delCheck == 1){
            alert("Record was deleted.")
        }
    </script>

<!-- 
!!!!!------------------------------------------------------------------------------------------------------------------------------------------------------!!!!!
  check VSDbridge.php for full documentation! the two pages work almost exactly the same but for different tables. differences will be touched upon here though.
!!!!!------------------------------------------------------------------------------------------------------------------------------------------------------!!!!!
-->

</body>
</html>