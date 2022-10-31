<?php

include_once ("./account.php");
 
    class SavingsAccount extends Account 
    {

        public function withdrawal($amount) 
        {
            // write code here. Return true if withdrawal goes through; false otherwise
            $currentBal = Parent::getBalance();
            if($currentBal - $amount < 0){
                return FALSE;
            } else {
                $this->balance -= $amount;
                echo " " . $this->balance;
                return TRUE;
            }

        } //end withdrawal

        public function getAccountDetails() 
        {
            $accountDetails = "<h2>Savings Account</h2>";
            $accountDetails .= parent::getAccountDetails();
            
            return $accountDetails;
        } //end getAccountDetails
        
    } // end Savings

// The code below runs everytime this class loads and 
// should be commented out after testing.

    //$savings = new SavingsAccount('S123', 5000, '03-20-2020');
    
    // echo $savings->getAccountDetails();
    
?>
