<?php
 
 	include_once ("./account.php");
    //include once so as to not stack with savings.php calling the same file
 
    class CheckingAccount extends Account //checkingaccount inherits account
    {
        const OVERDRAW_LIMIT = -200;
        //define set limit for overdraw in the account

        public function withdrawal($amount) 
        {
            // write code here. Return true if withdrawal goes through; false otherwise
            
            $currentBal = Parent::getBalance();
            //retrieve the current balance of the account before calculating anything

            if(($currentBal - $amount) < self::OVERDRAW_LIMIT){
                return FALSE;
                //if the withdrawal would cause the balance to exceed the limit, do nothing
            } 
            else 
            {
                $this->balance -= $amount;
                return TRUE;
                //if the withdrawal leaves the balance within the limit, perform the withdrawal
            }

        } // end withdrawal

        //freebie. I am giving you this code.
        public function getAccountDetails() 
        {
            $accountDetails = "<h2>Checking Account</h2>";
            $accountDetails .= parent::getAccountDetails();
            
            return $accountDetails;
            //return account details (grabbed from parent class's function) with a header
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
