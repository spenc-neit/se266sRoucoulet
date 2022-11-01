<?php
	// This is the base class for checking and savings accounts
	// It is declared **abstract** so that it can not be instantiated
	// Child classes must be derived that 
	// implement the withdrawal and getAccountDetails methods
	
	/* Note:
		You should implement all other methods in the class
	*/
	
    abstract class Account 
    {
        protected $accountId;
        protected $balance;
        protected $startDate;
        //create variables to store properties of the accounts
        
        public function __construct ($id, $bal, $startDt) 
        {
           $this->accountId = $id;
           $this->balance = $bal;
           $this->startDate = $startDt;
           //assign values to the variables as passed in by the constructor being called
        } // end constructor
        
        public function deposit ($amount) 
        {
            $this->balance += $amount;
            //add the value passed in to the balance
        } // end deposit

        abstract public function withdrawal($amount);
        // This is an abstract method. 
        // This method must be defined in all classes
        // that inherit from this class
        
        public function getStartDate() 
        {
            return $this->startDate;
            //return the stored start date
        } // end getStartDate

        public function getBalance()
        {
            return $this->balance;
            //return the stored balance
        } // end getBalance

        public function getAccountId() 
        {
            return $this->accountId;
            //return the stored account ID
        } // end getAccountId

        // Display AccountID, Balance and StartDate in a nice format
        protected function getAccountDetails()
        {
            return "Start date: $this->startDate Balance: $this->balance ID: $this->accountId";
            //return all account details
        } // end getAccountDetails
        
    } // end account

?>
