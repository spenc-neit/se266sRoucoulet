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

    $first = TRUE; //bool to keep track of whether or not the clause is the first one (changes if there's a WHERE or an AND at the front)

    $sql = "SELECT userID, username, pass, email, verified, birthday, joined, userRank, amtPosts, privilege FROM forum_users"; 

    if($first AND $un != ""){ //if the username parameter is not empty AND is the first clause
        $first = FALSE; //set the bool to false so future searches don't have WHERE in them
        $sql .= " WHERE username LIKE :bUN"; //concat to sql statement
        $binds['bUN'] = '%' . $un . '%'; //add bind for the parameter into array
    }

    if($first AND $email != ""){ //if the email is not empty AND is the first search
        $first = FALSE; //set the bool to false so future searches don't have WHERE in them
        $sql .= " WHERE email LIKE :bEmail"; //concat to sql statement
        $binds['bEmail'] = '%'.$email.'%'; //add bind for the parameter into array
    } 
    elseif(!$first AND $email != "") { //if email is not empty AND is NOT the first search
        $sql .= " AND email LIKE :bEmail"; //concat to sql statement
        $binds['bEmail'] = '%'.$email.'%'; //add bind for the parameter into array
    }

    if($first AND $priv != ""){
        $first = FALSE;
        $sql .= " WHERE privilege LIKE :bPriv";
        $binds['bPriv'] = '%'.$priv.'%'; 
    }
    elseif(!$first AND $priv != ""){ 
        $sql .= " AND privilege LIKE :bPriv";
        $binds['bPriv'] = '%'.$priv.'%'; 
    }//same idea as above if/else for email fields

    $stmt = $db->prepare($sql);//prepare sql statement

    $results = array(); //create empty results array (in case there are no results)
    if($stmt->execute($binds) AND $stmt->rowCount() > 0){ //execute statement w/binds, if there are >0 rows
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); //put results into array
    }

    //echo $sql;

    return ($results);
    
}

function getForums($title, $category){ //works much the same as getForumUsers

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

    return($results);

}

function getBridges($userID, $forumID){ //works much the same as getForumUsers
    global $db;

    $binds = array();

    $first = TRUE;

    $sql = "SELECT userID, forumID, bridgeID FROM bridge";

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
    
    $results = "Data was not deleted"; //set default result

    switch($tableName){ //check the table the function sends
        case "bridge": //if function sends bridge
            $idField = 'bridgeID'; //set id field (used in sql statement) to the relevant field
            break;
        case "forum_users":
            $idField = 'userID';
            break;
        case "forums":
            $idField = 'forumID';
            break;
    }

    $stmt = $db->prepare("DELETE FROM $tableName WHERE $idField = :bID");
    //using the tablename from parameters, and the field from the switch, build sql statement

    $binds = array(":bID" => $id); //fill id parameter with the passed id

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){ //execute statement w/binds, if it works:
        $results = 'Records deleted'; //set successful feedback
    }

    return ($results);

}

function getARecord($id, $tableName){
    global $db;

    $result = array();

    switch($tableName){ //check tablename parameter
        case 'forum_users': //if it's forum_users
            $fields = "userID, username, pass, email, verified, birthday, joined, userRank, amtPosts, privilege"; //set list of fields of the table passed in 
            $idField = "userID"; //set ID field
            //these vars to be used in sql statement, to allow this to be one function instead of 3
            break;
        case 'bridge':
            $fields = "bridgeID, userID, forumID";
            $idField = "bridgeID";
            break;
        case 'forums':
            $fields = "forumID, creator, title, category, created, pinned, openToReply, amtReplies, lastPost";
            $idField = "forumID";
            break;
    }

    $stmt = $db->prepare("SELECT $fields FROM $tableName WHERE $idField = :bID"); //prepare sql statement with the variables set or passed above

    $binds = array(":bID" => $id); //set bind using passed id

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){ //execute statement w/binds, if the results aren't empty:
        $results = $stmt->fetch(PDO::FETCH_ASSOC); //set the record into the results var
    }

    return ($results);
}

function addARecord($data){
    global $db;

    switch(count($data)){ //check length of data
        //the amount of data passed in is just as telling as sending the name of the table itself, since each table has a unique amount of columns
        case 9: //if the length is 9 (forum_users)
            $sql = "INSERT INTO forum_users SET username = :bUN, pass = :bPW, email = :bEM, verified = :bVF, birthday = :bBD, joined = :bDJ, userRank = :bRK, amtPosts = :bAP, privilege = :bPV";
            $binds = array(
                ":bUN" => $data[0],
                ":bPW" => $data[1],
                ":bEM" => $data[2],
                ":bVF" => $data[3],
                ":bBD" => $data[4],
                ":bDJ" => $data[5],
                ":bRK" => $data[6],
                ":bAP" => $data[7],
                ":bPV" => $data[8]
            );
            //set sql statement and binds using the data passed in
            break;

        case 2://if length is 2 (bridge)
            $sql = 'INSERT INTO bridge SET userID = :bUID, forumID = :bFID';
            $binds = array(
                ":bUID" => $data[0],
                ":bFID" => $data[1]
            );//set sql statement and binds using data passed in
            break;

        case 8: //if length is 8 (forums)
            $sql = 'INSERT INTO forums SET creator = :bCR, title = :bTL, category = :bCG, created = :bCD, pinned = :bPD, openToReply = :bOR, amtReplies = :bAR, lastPost = :bLP';
            $binds = array(
                ":bCR" => $data[0],
                ":bTL" => $data[1],
                ":bCG" => $data[2],
                ":bCD" => $data[3],
                ":bPD" => $data[4],
                ":bOR" => $data[5],
                ":bAR" => $data[6],
                ":bLP" => $data[7]
            ); //set sql statement and binds using data passed in
            break;
    }

    $stmt = $db->prepare($sql); //prep sql statement created in switch

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){ //execute statement w/ prepped binds, if results are >0:
        $results = 'Data added'; //set success feedback
    }

    return ($results);
}

function updateARecord($data){
    global $db;

    switch(count($data)){ //check length of list of data passed in
        //the amount of data passed in is just as telling as sending the name of the table itself, since each table has a unique amount of columns
        //one extra value is needed this time, since ID is needed to refer to the correct record

        case 10: //length 10 - forum_users
            $sql = "UPDATE forum_users SET username = :bUN, pass = :bPW, email = :bEM, verified = :bVF, birthday = :bBD, joined = :bDJ, userRank = :bRK, amtPosts = :bAP, privilege = :bPV WHERE userID = :bID";
            $binds = array(
                ":bUN" => $data[0],
                ":bPW" => $data[1],
                ":bEM" => $data[2],
                ":bVF" => $data[3],
                ":bBD" => $data[4],
                ":bDJ" => $data[5],
                ":bRK" => $data[6],
                ":bAP" => $data[7],
                ":bPV" => $data[8],
                ":bID" => $data[9]
            );//set sql statement and binds using data sent in
            break;

        case 3: //length 3 - bridge
            $sql = 'UPDATE bridge SET userID = :bUID, forumID = :bFID WHERE bridgeID = :bBID';
            $binds = array(
                ":bUID" => $data[0],
                ":bFID" => $data[1],
                ":bBID" => $data[2]
            );//set sql statement and binds using data sent in
            break;

        case 9://length 9 - forums
            $sql = 'UPDATE forums SET creator = :bCR, title = :bTL, category = :bCG, created = :bCD, pinned = :bPD, openToReply = :bOR, amtReplies = :bAR, lastPost = :bLP WHERE forumID = :bID';
            $binds = array(
                ":bCR" => $data[0],
                ":bTL" => $data[1],
                ":bCG" => $data[2],
                ":bCD" => $data[3],
                ":bPD" => $data[4],
                ":bOR" => $data[5],
                ":bAR" => $data[6],
                ":bLP" => $data[7],
                ":bID" => $data[8]
            );//set sql statement and binds using data sent in
            break;
    }

    $stmt = $db->prepare($sql); //prepare sl statement created in switch

    

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){  //execute statement using binds, if results are >0
        $results = 'Data updated'; //set successful feedback
    }

    return ($results);

}

function getUsername($uID){ //grabs a username corresponding to an ID, for VSDbridge's more user friendly table
    global $db;

    $stmt = $db->prepare("SELECT username FROM forum_users WHERE userID = :bID"); //prep sql statement to get the username for the passed id

    $binds = array(":bID" => $uID); //set binds using passed id

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){ //execute statement using binds, if results >0
        $results = $stmt->fetch(PDO::PARAM_STR); //set results to the fetched "array"
    }

    return ($results);
}

function getTitle($fID){//same function and purpose as getUsername, but for grabbing a forum title
    global $db;

    $stmt = $db->prepare("SELECT title FROM forums WHERE forumID = :bID");

    $binds = array(":bID" => $fID);

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = $stmt->fetch(PDO::PARAM_STR);
    }

    return ($results);
}

function isValidUID($id){ //function to check if a user ID passed in to the function ties to an existing record
    //validation for the add bridge form - passing an invalid foreign key would throw a sql syntax error and break the page
    global $db;

    $stmt = $db->prepare("SELECT username FROM forum_users WHERE userID = :bID"); //prep sql statement to look for a valid record

    $binds = array(":bID" => $id); //set binds using passed id

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){//execute statement, if the statement finds a record:
        $results = TRUE; //the ID is valid
    } else{ //if it doesn't find a record:
        $results = FALSE; //the ID is not valid
    }

    return($results);//return true or false depending on the statement's results
}

function isValidFID($id){//same function and purpose as isValidUID, but for checking a forum ID
    global $db;

    $stmt = $db->prepare("SELECT title FROM forums WHERE forumID = :bID");

    $binds = array(":bID" => $id);

    if($stmt->execute($binds) AND $stmt->rowCount() > 0){
        $results = TRUE;
    } else{
        $results = FALSE;
    }

    return($results);
}

function getValidIDs($table){ //function to get all valid IDs to display in tables for a better user experience when adding bridges and forums
    global $db;


    switch($table){//check tablename
        case "forum_users":
            $stmt = $db->prepare("SELECT userID, username FROM forum_users"); //grab username and ID from forum_users
            break;
        case "forums";
            $stmt = $db->prepare("SELECT forumID, title FROM forums"); //grab title and forum ID from forums
            break;
    }

    if($stmt->execute() AND $stmt->rowCount() > 0){//execute statement, if results >0
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);//set results to the grabbed records
    }

    return($results);
}