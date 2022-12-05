<?php
session_start(); //open session

include __DIR__ . '/models/mdl_schools.php';
//include data model file
include __DIR__ . '/postcheck.php';
//include file w/ function to check for POST method



if (isset ($_FILES['userfile'])){ //if there is a file from the userfile input
    $tmpName = $_FILES['userfile']['tmp_name'];
        //store the file's temporary name
    $path = getcwd() . DIRECTORY_SEPARATOR . 'uploads';
        //store the path where the file will go
    $newName = $path . DIRECTORY_SEPARATOR . $_FILES['userfile']['name'];
        //append the file's name to the path
    move_uploaded_file($tmpName, $newName);
        //move file to this new location
    $_SESSION['uploaded'] = TRUE;
        //set session bool for checking if the upload process is done

    deleteAllSchools();
        //clear existing records in table

    insertSchoolsFromFile($newName);
        //insert new records (from uploaded csv) into table

    header('location: schoolSearch.php');
        //redirect to search page
}

include __DIR__ . '/header.php';
    //display header/nav

?>

<div class='container p-5 border border-dark bg-light'>

    <h2>Upload File</h2>
    <p>Please select a file to upload.</p>

    <form action='schoolUpload.php' method='post' enctype='multipart/form-data'>
        <input type="file" class="form-control" name="userfile" />
        <button type='submit' class='btn btn-secondary mt-2'>Submit</button>
    </form>

    <br />

</div> <!--upload page html-->

<?php include 'footer.php'; ?>
<!--display footer-->
    
</body>
</html>