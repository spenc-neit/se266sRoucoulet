<?php
    session_start(); //open session

    include __DIR__ . '/models/mdl_schools.php';
    //include data model file
    include __DIR__ . '/postcheck.php';
    //include file w/ function to check for POST method

    include __DIR__ . '/header.php';
    //display header

    $searchName = "";
    $searchCity = "";
    $searchState = "";
    //initialize empty vars so the value "sticking" isn't ruined by user not sending values

    $searched = FALSE;
    //init bool for searching process being finished to false


    if(isPostRequest()){ //if the page is POST
        $searchName = filter_input(INPUT_POST, 'inpName');
        $searchCity = filter_input(INPUT_POST, 'inpCity');
        $searchState = filter_input(INPUT_POST, 'inpState');
        //store user input in vars

        $schools = getSchools($searchName, $searchCity, $searchState);
        //search w/ parameters and store in var

        $searched = TRUE;
        //set bool to confirm searching is done

    }


?>

<!-- --------------------- -->

<div class='container p-5 border border-dark bg-light'>

    <?php if(!isset($_SESSION['uploaded']) OR !$_SESSION['uploaded']):?> <!--if session var (that confirms uploading is done) is false or does not exist-->
        <br />
        <h3 style='text-align:center;'>There is no file currently uploaded. Please go to the <a href='schoolUpload.php'>upload page</a> to upload one.</h3>
    <?php elseif ($_SESSION['uploaded']):?> <!--if aforementioned session var is true, aka file is uploaded-->

        <h2>Search Schools</h2>

        <form action='schoolSearch.php' method='post'>

            <div class='form-group'>
                <label for='inpName'>School name</label>
                &nbsp;
                <input type='text' name='inpName' class='form-control' value="<?=$searchName?>" />
            </div>

            <div class='form-group'>
                <label for='inpName'>City</label>
                &nbsp;
                <input type='text' name='inpCity' class='form-control' value="<?=$searchCity?>" />
            </div>
            
            <div class='form-group'>
                <label for='inpName'>State</label>
                &nbsp;
                <input type='text' name='inpState' class='form-control' maxlength='2' value="<?=$searchState?>" />
            </div>

            <br />

            <button type='submit' class='btn btn-outline-primary'>Search</button>

        </form>
        

    <?php endif;?>

    <?php if($searched):?><!--if searching is done-->

        <br />
        <p><?=count($schools)?> matching schools found.</p> <!--display number of matching results-->

        <table class='table table-striped'>

        <thead>

            <tr>
                <th>School Name</th>
                <th>City</th>
                <th>State</th>
            </tr>

        </thead>

        <tbody>

            <?php foreach ($schools as $row):?>
                <tr>
                    <td><?= $row['schoolName'] ?></td>
                    <td><?= $row['schoolCity'] ?></td>
                    <td><?= $row['schoolState'] ?></td>
                </tr>
            <?php endforeach; ?>
            <!--loop through and put results into table-->

        </tbody>

        </table>

    <?php endif;?>

</div>

<?php include 'footer.php'; ?><!--display footer-->

</body>
</html>