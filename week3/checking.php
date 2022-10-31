<?php
 
 	include_once ("./account.php");
 
    class CheckingAccount extends Account 
    {
        const OVERDRAW_LIMIT = -200;

        public function withdrawal($amount) 
        {
            // write code here. Return true if withdrawal goes through; false otherwise
            $currentBal = Parent::getBalance();
            // echo "currentBal = $currentBal currentbal type = " . gettype($currentBal) . " | ";
            // echo "amount = $amount amount type = " . gettype($amount);
            // echo $currentBal - $amount;
            if(($currentBal - $amount) < self::OVERDRAW_LIMIT){
                return FALSE;
            } else {
                //$this->balance -= $amount;
                //echo " " . $this->balance;
                return TRUE;
                
            }

        } // end withdrawal

        public function setBalance($value){
            $this->balance = $value;
        }

        //freebie. I am giving you this code.
        public function getAccountDetails() 
        {
            $accountDetails = "<h2>Checking Account</h2>";
            $accountDetails .= parent::getAccountDetails();
            
            return $accountDetails;
        }
    }


// The code below runs everytime this class loads and 
// should be commented out after testing.
    
    //$checking = new CheckingAccount ('C123', 1000, '12-20-2019');
    // $checking->withdrawal(200);
    // $checking->deposit(500);
    
    // echo $checking->getAccountDetails();
    // echo $checking->getStartDate();
    
?>
