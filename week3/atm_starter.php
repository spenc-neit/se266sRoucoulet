<?php
include "checking.php";
include "savings.php";
//include checking and savings class files
include "postcheck.php";
//include function to check if the page is a POST

    if(isPostRequest()){
        $cBalance = filter_input(INPUT_POST, 'checkingBalance', FILTER_VALIDATE_FLOAT);
        $cDate = filter_input(INPUT_POST, 'checkingDate');
        $cID = filter_input(INPUT_POST, 'checkingAccountId');
        $sBalance = filter_input(INPUT_POST, 'savingsBalance', FILTER_VALIDATE_FLOAT);
        $sDate = filter_input(INPUT_POST, 'savingsDate');
        $sID = filter_input(INPUT_POST, 'savingsAccountId');
        //if the page IS a POST, create variables for accounts info using info passed along by the form
    } else {
        $cBalance = 1001;
        $cDate = '12-20-2019';
        $cID = 'C123';
        $sBalance = 5000;
        $sDate = '3-20-2020';
        $sID = 'S123';
        //if the page is NOT a post, create variables for accounts info using default values
    }

    $checking = new CheckingAccount($cID, $cBalance, $cDate);
    $savings = new SavingsAccount($sID, $sBalance, $sDate);
    //create instances of account objects, using the variables defined in the above if statement

    if (isset ($_POST['withdrawChecking'])) 
    {
        $checking->withdrawal(filter_input(INPUT_POST, 'checkingWithdrawAmount', FILTER_VALIDATE_FLOAT));
    } 
    else if (isset ($_POST['depositChecking'])) 
    {   
        $checking->deposit(filter_input(INPUT_POST, 'checkingDepositAmount', FILTER_VALIDATE_FLOAT));
    } 
    else if (isset ($_POST['withdrawSavings'])) 
    {
        $savings->withdrawal(filter_input(INPUT_POST, 'savingsWithdrawAmount', FILTER_VALIDATE_FLOAT));
    } 
    else if (isset ($_POST['depositSavings'])) 
    {
        $savings->deposit(filter_input(INPUT_POST, 'savingsDepositAmount', FILTER_VALIDATE_FLOAT));
    }
    //depending on what button the user presses (determined by checking POST for the values passed by the buttons),
    //perform the corresponding function on the corresponding account,
        //using the user's input as the amount passed into the function
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM</title>
    <style type="text/css">
        body {
            margin-left: 120px;
            margin-top: 50px;
        }
       .wrapper {
            display: grid;
            grid-template-columns: 300px 300px;
        }
        .account {
            border: 1px solid black;
            padding: 10px;
        }
        .label {
            text-align: right;
            padding-right: 10px;
            margin-bottom: 5px;
        }
        label {
           font-weight: bold;
        }
        input[type=text] {width: 80px;}
        .error {color: red;}
        .accountInner {
            margin-left:10px;margin-top:10px;
        }
    </style>
</head>
<body>

    <form method="post" >
       
        <input type="hidden" name="checkingAccountId" value="<?=$checking->getAccountID()?>" />
        <input type="hidden" name="checkingDate" value="<?=$checking->getStartDate()?>" />
        <input type="hidden" name="checkingBalance" value="<?=$checking->getBalance()?>" />
        <input type="hidden" name="savingsAccountId" value="<?=$savings->getAccountID()?>" />
        <input type="hidden" name="savingsDate" value="<?=$savings->getStartDate()?>" />
        <input type="hidden" name="savingsBalance" value="<?=$savings->getBalance()?>" />
        <!--take the values for each input field from the objects' stored values-->
        
    <h1>ATM</h1>
        <div class="wrapper">
            
            <div class="account">
              
                    <div class="accountInner">
                        <h2>Checking</h2>
                        <label for="checkingAccountId">ID: <?= $checking->getAccountID() ?></label><br />
                        <label for="checkingBalance">Balance: <?= $checking->getBalance() ?></label><br />
                        <label for="checkingDate">Start Date: <?= $checking->getStartDate() ?></label>
                        <!--display the values stored in the checking object-->
                    </div>
                    
                    <div class="accountInner">
                        <input type="text" name="checkingWithdrawAmount" value="" />
                        <input type="submit" name="withdrawChecking" value="Withdraw" />
                    </div>
                    <div class="accountInner">
                        <input type="text" name="checkingDepositAmount" value="" />
                        <input type="submit" name="depositChecking" value="Deposit" /><br />
                    </div>
            
            </div>

            <div class="account">

                    <div class="accountInner">
                        <h2>Savings</h2>
                        <label for="savingsAccountID">ID: <?= $savings->getAccountID() ?></label><br />
                        <label for="savingsBalance">Balance: <?= $savings->getBalance() ?></label><br />
                        <label for="savingsDate">Start Date: <?= $savings->getStartDate() ?></label>
                        <!--display the values stored in the savings object-->
                    </div>
                    
                    <div class="accountInner">
                        <input type="text" name="savingsWithdrawAmount" value="" />
                        <input type="submit" name="withdrawSavings" value="Withdraw" />
                    </div>
                    <div class="accountInner">
                        <input type="text" name="savingsDepositAmount" value="" />
                        <input type="submit" name="depositSavings" value="Deposit" /><br />
                    </div>
            
            </div>
            
        </div>
    </form>
</body>
</html>
