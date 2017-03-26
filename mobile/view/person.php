<?php
class Person
{
    // property declaration
    public $id;
    public $firstname;
    public $lastname;

    // method declaration
    public function displayVar() {
        
    }
}
class Transaction{
	public $transactionID;
	public $creatorID;
	public $totalCost;
	public $totalPaid;
	public $numberOfPeople;
	public $people[];
	public $contributions[];
}

?>