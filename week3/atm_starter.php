<?php
include "checking.php";
include "savings.php";

$checking = "";
$savings = "";

// $checking = new CheckingAccount ('C123', 1000, '12-20-2019');
// $savings = new SavingsAccount('S123', 5000, '03-20-2020'); 

    // if (empty($_POST))
    // {
    //     $checking = new CheckingAccount ('C123', 1000, '12-20-2019');
    //     $savings = new SavingsAccount('S123', 5000, '03-20-2020'); 
    // }


    if (isset ($_POST['withdrawChecking'])) 
    {

        echo "<pre style='background-color:blue;color:white;'>";
        var_dump($_POST);
        echo "</pre>";

        $checking = new CheckingAccount('C123', filter_input(INPUT_POST, 'checkingBalance', FILTER_VALIDATE_FLOAT), '12-20-2019');
        

        echo "I pressed the checking withdrawal button | "; //testing
        echo " input is " . filter_input(INPUT_POST, 'checkingWithdrawAmount', FILTER_VALIDATE_FLOAT) . " | "; //testing

        
        if($checking->withdrawal(filter_input(INPUT_POST, 'checkingWithdrawAmount', FILTER_VALIDATE_FLOAT))){
            $balance = filter_input(INPUT_POST, 'checkingBalance', FILTER_VALIDATE_FLOAT);
            $withdraw = filter_input(INPUT_POST, 'checkingWithdrawAmount', FILTER_VALIDATE_FLOAT);
            $nb = $balance - $withdraw;
            $_POST['checkingBalance'] = $nb;
            $checking = new CheckingAccount ('C123', $_POST['checkingBalance'], '12-20-2019');
        }
        // $newBalance = $checking->getBalance();
        // echo " new balance is $newBalance | ";

        //echo " balance before obj creation is " . $checking->getBalance(); //testing
        echo " | new balance before obj is $nb | ";

        
        //$checking->setBalance($nb);

        echo " | balance after obj creation is " . $checking->getBalance(); //testing
        //echo " | end of w/d c"; //testing

        
    } 
    else if (isset ($_POST['depositChecking'])) 
    {
        echo "I pressed the checking deposit button | ";
        
        $checking->deposit(filter_input(INPUT_POST, 'checkingDepositAmount', FILTER_VALIDATE_FLOAT));
        
        echo filter_input(INPUT_POST, 'checkingWithdrawAmount', FILTER_VALIDATE_FLOAT);
        echo $checking->getBalance();
        //include "checking.php";
    } 
    else if (isset ($_POST['withdrawSavings'])) 
    {
        echo "I pressed the savings withdrawal button | ";
        echo filter_input(INPUT_POST, 'savingsWithdrawAmount', FILTER_VALIDATE_FLOAT);
        
        $savings->withdrawal(filter_input(INPUT_POST, 'savingsWithdrawAmount', FILTER_VALIDATE_FLOAT));
        
    } 
    else if (isset ($_POST['depositSavings'])) 
    {
        echo "I pressed the savings deposit button | ";
        //include "savings.php";
        $savings->deposit(filter_input(INPUT_POST, 'savingsDepositAmount', FILTER_VALIDATE_FLOAT));
        echo filter_input(INPUT_POST, 'savingsDepositAmount', FILTER_VALIDATE_FLOAT);
        echo " ";
        echo $savings->getBalance();
    } else {
        $checking = new CheckingAccount ('C123', 1000, '12-20-2019');
        $savings = new SavingsAccount('S123', 5000, '03-20-2020');
        echo "new page load (hopefully)";
    }
    
    echo "<pre style='background-color:indianred;'>";
    var_dump($_POST);
    echo "</pre>";
     
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
       
        <input type="hidden" name="checkingAccountId" value="C123" />
        <input type="hidden" name="checkingDate" value="12-20-2019" />
        <input type="hidden" name="checkingBalance" value="1000" />
        <input type="hidden" name="savingsAccountId" value="S123" />
        <input type="hidden" name="savingsDate" value="03-20-2020" />
        <input type="hidden" name="savingsBalance" value="5000" />
        
    <h1>ATM</h1>
        <div class="wrapper">
            
            <div class="account">
              
                    <div class="accountInner">
                        <h2>Checking</h2>
                        <p>ID: <?= $checking->getAccountID() ?></p>
                        <p>Balance: <?= $checking->getBalance() ?></p>
                        <p>Start Date: <?= $checking->getStartDate() ?></p>
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
                        <p>ID: <?= $savings->getAccountID() ?></p>
                        <p>Balance: <?= $savings->getBalance() ?></p>
                        <p>Start Date: <?= $savings->getStartDate() ?></p>
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
