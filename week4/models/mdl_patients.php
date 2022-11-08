<?php

    include (__DIR__ . '/db.php');

    function getPatients(){
        global $db;

        $results = [];

        $stmt = $db->prepare("SELECT id, patientFirstName, patientLastName, patientMarried, patientBirthDate FROM patients ORDER BY patientLastName");

        if ($stmt->execute() && $stmt->rowCount() > 0 ){
            $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        }

        return ($results);
    }

    function addPatient($fName, $lName, $mar, $bday){
        global $db;
        $stmt = $db->prepare("INSERT INTO patients SET patientFirstName = :bFirst, patientLastName = :bLast, patientMarried = :bMarried, patientBirthDate = :bBirthday");

        $binds = array(
            ":bFirst" => $fName,
            ":bLast" => $lName,
            ":bMarried" => $mar,
            ":bBirthday" => $bday
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){
            $results = "Data added.";
        }

        return ($results);
    }

    // $result = addPatient('Luke', 'Bell', '0', '2019-1-5');
    // echo "<pre>";
    // var_dump(getPatients());
    // echo "</pre>";
