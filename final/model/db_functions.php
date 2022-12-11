<?php

include_once (__DIR__ . '\db.php');

function getALogin($un){
    //password for spenc is 437

    global $db;
        //use global db var

    $result = [];
        //use global array variable

    $stmt = $db->prepare("SELECT userID, username, encPass, salt FROM users WHERE username=:bUN");
        //prepare static sql statement and store in var

    $binds = array(
        ":bUN" => $un
    ); //store value needed for select statement into binds array

    if ($stmt->execute($binds) && $stmt->rowCount() > 0) { //if the statement finds a valid record
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
            //store fetched record in results var
    }
    else{ //if the statement doesn't find a value
        $results = "No user with that name found.";
            //store feedback in var
    }

    return($results); 
        //return either feedback or record
}

function getForumUsers($un, $email, $priv){
    global $db;

    $binds = array();

    $first = TRUE;

    $sql = "SELECT userID, username, pass, email, verified, birthday, joined, userRank, amtPosts, privilege FROM forum_users";

    if($first AND $un != ""){
        $first = FALSE;
        $sql .= " WHERE username LIKE :bUN";
        $binds['bUN'] = '%' . $un . '%';
    }

    if($first AND $email != ""){
        $first = FALSE;
        $sql .= " WHERE email LIKE :bEmail";
        $binds['bEmail'] = '%'.$email.'%';
    } 
    elseif(!$first AND $email != "") {
        $sql .= " AND email LIKE :bEmail";
        $binds['bEmail'] = '%'.$email.'%';
    }

    if($first AND $priv != ""){
        $first = FALSE;
        $sql .= " WHERE privilege LIKE :bPriv";
        $binds['bPriv'] = '%'.$priv.'%';
    }
    elseif(!$first AND $priv != ""){
        $sql .= " AND privilege LIKE :bPriv";
        $binds['bPriv'] = '%'.$priv.'%';
    }

    $stmt = $db->prepare($sql);

    $results = array();
    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //echo $sql;

    return ($results);
    
}

function getForums($title, $category){

    global $db;

    $binds = array();

    $first = TRUE;

    $sql = "SELECT forumID, creator, title, category, created, pinned, openToReply, amtReplies, lastPost FROM forums";

    if($first AND $title != ""){
        $first = FALSE;
        $sql .= " WHERE title LIKE :bTitle";
        $binds['bTitle'] = "%$title%";
    }

    if($first AND $category != ""){
        $first = FALSE;
        $sql .= " WHERE category LIKE :bCat";
        $binds['bCat'] = "%$category%";
    }
    elseif(!$first AND $category != ""){
        $sql .= " AND category LIKE :bCat";
        $binds['bCat'] = "%$category%";
    }

    $stmt = $db->prepare($sql);

    $results = array();
    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

function getBridges($userID, $forumID){

    global $db;

    $binds = array();

    $first = TRUE;

    $sql = "SELECT userID, forumID FROM bridge";

    if($first AND $userID != ""){
        $first = FALSE;
        $sql .= " WHERE userID LIKE :bUID";
        $binds['bUID'] = "%$userID%";
    }

    if($first AND $forumID != ""){
        $first = FALSE;
        $sql .= " WHERE forumID LIKE :bFID";
        $binds['bFID'] = "%$forumID%";
    }
    elseif(!$first AND $forumID != ""){
        $sql .= " AND forumID LIKE :bFID";
        $binds['bFID]'] = "%$forumID%";
    }

    $stmt = $db->prepare($sql);
    
    $results = array();
    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return ($results);

}

function deleteRecord($id, $tableName){
    global $db;
    
    $results = "Data was not deleted";

    switch($tableName){
        case "forum_users":
        case "bridge":
            $idField = 'userID';
            break:
        case "forums":
            $idField = 'forumID';
            break:
    }

    $stmt = $db->prepare("DELETE FROM $tableName WHERE $idField = :bID");

    $binds = array(":bID" => $id);

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = 'Records deleted';
    }

    return ($results);

}

function getARecord($id, $tableName){
    global $db;

    $result = array();

    switch($tableName){
        case 'forum_users':
            $fields = "userID, username, pass, email, verified, birthday, joined, userRank, amtPosts, privilege";
            $idField = "userID";
            break;
        case 'bridge':
            $fields = "userID, forumID";
            $idField = "userID";
            break;
        case 'forums':
            $fields = "forumID, creator, title, category, created, pinned, openToReply, amtReplies, lastPost";
            $idField = "forumID";
            break;
    }

    $stmt = $db->prepare("SELECT $fields FROM $tableName WHERE $idField = :bID");

    $binds = array(":bID" => $id);

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return ($results);
}

function addAForumUser($data){
    global $db;

    switch(count($data)){
        case 9:
            $sql = "INSERT INTO forum_users SET username = :bUN, pass = :bPW, email = :bEM, verified = :bVF, birthday = :bBD, joined = :bDJ, userRank = :bRK, amtPosts = :bAP, privilege = :bPV"
            $binds = array(
                ":bUN" => $data[0];
                ":bPW" => $data[1];
                ":bEM" => $data[2];
                ":bVF" => $data[3];
                ":bBD" => $data[4];
                ":bDJ" => $data[5];
                ":bRK" => $data[6];
                ":bAP" => $data[7];
                ":bPV" => $data[8];
            )
            break;

        case 2:
            $sql = 'INSERT INTO bridge SET userID = :bUID, forumID = :bFID';
            $binds = array(
                ":bUID" => $data[0];
                ":bFID" => $data
            )
            break;

        case 8:
            $sql = 'INSERT INTO forums SET creator = :bCR, title = :bTL, category = :bCG, created = :bCD, pinned = :bPD, openToReply = :bOR, amtReplies = :bAR, lastPost = :bLP';
            $binds = array(
                ":bCR" => $data[0];
                ":bTL" => $data[1];
                ":bCG" => $data[2];
                ":bCD" => $data[3];
                ":bPD" => $data[4];
                ":bOR" => $data[5];
                ":bAR" => $data[6];
                ":bLP" => $data[7];
            )
            break;
    }

    $stmt = $db->prepare($sql);

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = 'Data added';
    }

    return ($results);
}