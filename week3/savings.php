<?php

include_once ("./account.php");
//include once so as to not stack with checking.php calling the same file

    class SavingsAccount extends Account //savingsaccount inherits account
    {

        public function withdrawal($amount) 
        {
            // write code here. Return true if withdrawal goes through; false otherwise

            $currentBal = Parent::getBalance();
            //retrieve the current balance of the account before calculating anything

            if($currentBal - $amount < 0){
                return FALSE;
                //if the withdrawal would cause the balance to zip below zero, do nothing
            } 
            else 
            {
                $this->balance -= $amount;
                return TRUE;
                //if the withdrawal leaves the balance above zero, perform the withdrawal
            }

        } //end withdrawal

        public function getAccountDetails() 
        {
            $accountDetails = "<h2>Savings Account</h2>";
            $accountDetails .= parent::getAccountDetails();
            
            return $accountDetails;
            //return account details (grabbed from parent class's function) with a header
        } //end getAccountDetails
        
    } // end Savings

// The code below runs everytime this class loads and 
// should be commented out after testing.

    //$savings = new SavingsAccount('S123', 5000, '03-20-2020');
    
    // echo $savings->getAccountDetails();
    
?>
