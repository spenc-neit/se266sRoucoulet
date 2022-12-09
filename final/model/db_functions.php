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

}

function getARecord($id, $tableName){

}
