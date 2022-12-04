<?php

    include (__DIR__ . '/db.php');

    function getPatients($fName, $lName, $mar){
        global $db; 
            //use global var db

        $results = []; 
            //create empty results list

        $sql = "SELECT id, patientFirstName, patientLastName, patientMarried, patientBirthDate FROM patients WHERE 0=0"; 
            //define base sql statement

        $binds = [];
            //create empty binds array (will only fill if user sends search values)

        if ($fName != ""){ //if fName is not empty
            $sql .= " AND patientFirstName LIKE :bfName"; 
                //append part of sql statement
            $binds['bfName'] = '%' . $fName . '%'; 
                //enter corresponding value into the binds array + wildcards
        }
        if ($lName != ""){ //if lname is not empty
            $sql .= " AND patientLastName LIKE :blName";
                //append part of sql statement
            $binds['blName'] = '%' . $lName . '%';
                //enter corresponding value into the binds array + wildcards

        }
        switch ($mar){
            case "1": //if switch contains 1
                $sql .= " AND patientMarried = 1";
                    //append part of sql statement
                break;
            case "0": //if switch contains 0
                $sql .= " AND patientMarried = 0";
                    //append part of sql statement
                break;
        }
        

        $stmt = $db->prepare($sql); 
            //prepare statement defined (& possibly appended to) above


        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){ //execute statement using binds
            $results = $stmt->fetchall(PDO::FETCH_ASSOC); 
                //add search results into var
        }

        return ($results);
            //return search results
    }

    function addPatient($fName, $lName, $mar, $bday){
        global $db; 
            //use global var db
        $stmt = $db->prepare("INSERT INTO patients SET patientFirstName = :bFirst, patientLastName = :bLast, patientMarried = :bMarried, patientBirthDate = :bBirthday");
            //prepare static sql statement and store in var

        $binds = array(
            ":bFirst" => $fName,
            ":bLast" => $lName,
            ":bMarried" => $mar,
            ":bBirthday" => $bday
        ); //put values needed for the insert statement into array

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){  //execute statement using binds array
            $results = "Data added."; //store feedback
        }

        return ($results); //return results
    }

    function updatePatient($id, $fName, $lName, $mar, $bday){
        global $db; //use global var db

        $results = ""; 
            //use global var db

        $stmt = $db->prepare("UPDATE patients SET patientFirstName = :bFirst, patientLastName = :bLast, patientMarried = :bMarried, patientBirthDate = :bBirthday WHERE id = :bID");
            //prepare static sql statement and store in var

        $binds = array(
            ":bID" => $id,
            ":bFirst" => $fName,
            ":bLast" => $lName,
            ":bMarried" => $mar,
            ":bBirthday" => $bday
        ); //put values needed for update statement into array

        if($stmt->execute($binds) AND $stmt->rowCount() > 0){ //execute statement using binds array
            $results = "Data updated"; 
                //store feedback into var
        }

        return ($results); //return results
    }

    function deletePatient ($id) {
        global $db; 
            //use global var db
        
        $results = "Data was not deleted"; 
            //set default results value

        $stmt = $db->prepare("DELETE FROM patients WHERE id=:bID");
            //set static sql statement and store in var
        
        $binds = array(
            ":bID" => $id
        ); //store value needed for delete statement in array
        
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) { //if the statement sucessfully deletes a record
            $results = 'Data Deleted'; 
            //store feedback in var
        }
        
        return ($results); //return results
    }

    function getAPatient($id){
        global $db; //use global var db

        $result = [];
            //create empty results array

        $stmt = $db->prepare("SELECT id, patientFirstName, patientLastName, patientMarried, patientBirthDate FROM patients WHERE id=:bID");
            //create static sql statement and store in var

        $binds = array(
            ":bID" => $id
        ); //store value needed for select statement in array

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {//execute statement
            $results = $stmt->fetch(PDO::FETCH_ASSOC); 
                //put the fetched record into var
        }

        return($results); 
            //return record
    }

    function getAUser($un){
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
