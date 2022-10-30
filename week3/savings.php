<?php

include ("./account.php");
 
    class SavingsAccount extends Account 
    {

        public function withdrawal($amount) 
        {
            // write code here. Return true if withdrawal goes through; false otherwise
        } //end withdrawal

        public function getAccountDetails() 
        {
           // look at how it's defined in other class. You should be able to figure this out ...
        } //end getAccountDetails
        
    } // end Savings

// The code below runs everytime this class loads and 
// should be commented out after testing.

    $savings = new SavingsAccount('S123', 5000, '03-20-2020');
    
    echo $savings->getAccountDetails();
    
?>
