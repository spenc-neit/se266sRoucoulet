<?php

include_once __DIR__ . '/includes/header.php';
include __DIR__ . '/model/db_functions.php';
include __DIR__ . '/includes/postcheck.php';

$searchTitle = "";
$searchCategory = "";

$deleted = 0;

if(isPostRequest()){
    $searchTitle = filter_input(INPUT_POST, 'inputTitle');
    $searchCategory = filter_input(INPUT_POST, 'inputCategory');

    if(isset($_POST['forumID'])){
        $id = filter_input(INPUT_POST, 'forumID');
        deleteRecord($id, 'forums');
        $deleted = 1;
    }
}

$forums = getForums($searchTitle, $searchCategory);

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

        <h1 class='my-2'>View & Search - Forums</h1>

        <form action='VSDforums.php' method='post'>
            <table style='width:100%;'>
                <tr>
                    <td><label for='inputTitle'>Title</label></td>
                    <td><label for='inputCategory'>Category</label></td>
                </tr>
                <tr>
                    <td><input class='form-control' type='text' name='inputTitle' id='inputTitle'></td>
                    <td>
                        <select name='inputCategory' class='form-control'>
                            <option value='' selected></option>    
                            <option value='meta'>Meta</option>
                            <option value='general'>General</option>
                            <option value='support'>Support</option>
                            <option value='news'>News</option>
                            <option value='hobbies'>Hobbies</option>
                            <option value='debate'>Debate</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><button class='btn btn-outline-success my-2' type='submit'>Search</button></td>
                </tr>
            </table>
    </form>

    <p><?=count($forums)?> matching forums found.</p>

    <table class='table table-striped'>
        <tr>
            <th>ID</th>    
            <th>Title</th>
            <th>Creator</th>
            <th>Category</th>
            <th>Created on</th>
            <th>Pinned?</th>
            <th>Open to replies?</th>
            <th>Length of thread</th>
            <th>Last reply</th>
            <th></th>
        </tr>

        <?php foreach($forums as $row):?>

            <tr>
                <td><?=$row['forumID']?></td>            
                <td><?=$row['title']?></td>
                <td><?=getUsername($row['creator'])['username']?> - ID #<?=$row['creator']?></td>
                <td><?=$row['category']?></td>
                <td><?=$row['created']?></td>
                <td>
                    <?php if($row['pinned'] == 1): ?>
                        Yes
                    <?php else: ?>
                        No
                    <?php endif; ?> 
                </td>
                <td>
                    <?php if($row['openToReply'] == 1): ?>
                        Yes
                    <?php else: ?>
                        No
                    <?php endif; ?> 
                </td>
                <td><?=$row['amtReplies']?> posts</td>
                <td><?=$row['lastPost']?></td>
                <td>
                    <button onclick="window.location.href='AUforums.php?action=update&forumID=<?=$row['forumID']?>';" class='btn oneline'>✎</button>
                        <form action="VSDforums.php" method="post">
                            <input type="hidden" name="forumID" value="<?= $row['forumID'] ?>" />
                            <button class="btn oneline" type="submit">🗑️</button>
                        </form>
                </td>
            </tr>
        <?php endforeach;?>
    </div>

    <?php include_once 'includes/footer.php';?>

    <script>
        var delCheck = document.querySelector('#deleted').getAttribute('value')
        if(delCheck == 1){
            alert("Record was deleted.")
        }
    </script>

</body>
</html>