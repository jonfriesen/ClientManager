<?php
class Customer
{
	private $customerId;
	public function getCustomerId(){return $this->customerId;}
	private $firstName;
	public function getFirstName(){return $this->firstName;}
	private $lastName;
	public function getLastName(){return $this->lastName;}
	public function getFullName(){return $this->firstName.' '.$this->lastName;}
	public function getIndexName(){return $this->lastName.', '.$this->firstName;}
	
	private $streetAddress;
	public function getStreetAddress(){return $this->streetAddress;}
	private $city;
	public function getCity(){return $this->city;}
	private $province;
	public function getProvince(){return $this->province;}
	
	private $phoneNumber;
	public function getPhoneNumber(){return $this->phoneNumber;}
	private $emailAddress;
	public function getEmailAddress(){return $this->emailAddress;}
	
private static function GetCustomerObject($item)
{
	$c = new Customer();
	
	$c->customerId = $item->CustomerId;
	$c->firstName = $item->FirstName;
	$c->lastName = $item->LastName;
	
	$c->streetAddress = $item->StreetAddress;
	$c->city = $item->City;
	$c->province = $item->Province;
	
	$c->phoneNumber = $item->PhoneNumber;
	$c->emailAddress = $item->EmailAddress;

	return $c;
}

	public static function GetCustomer($id)
	{
		$reader = Connection::ScalarQuery('GetCustomer', $id);
		return Customer::GetCustomerObject($reader);
	}
	public static function GetAllCustomers()
	{
		$reader = Connection::Query('GetAllCustomers');
		
		$customers = array();
		foreach($reader as $item)
		{			
			array_push($customers, Customer::GetCustomerObject($item));
		}
		
		return $customers;
	}
	public static function CustomerSearch($name)
	{
		$reader = Connection::Query('CustomerSearch', $name);
		$customers = array();
		foreach($reader as $item)
		{			
			array_push($customers, Customer::GetCustomerObject($item));
		}
		
		return $customers;
	}
	public static function CreateCustomer($firstName, $lastName, $streetAddress, $city, $province, $phoneNumber, $emailAddress)
	{
		$customerId = Connection::ScalarQuery('InsertCustomer', $firstName, $lastName, $streetAddress, $city, $province, $phoneNumber, $emailAddress);
		
		$c = new Customer();
		$c->customerId = $customerId;
		$c->firstName = $firstName;
		$c->lastName = $lastName;
		$c->streetAddress = $streetAddress;
		$c->city = $city;
		$c->province = $province;
		$c->phoneNumber = $phoneNumber;
		$c->emailAddress = $emailAddress;
		
		return $c;
	}	
}
?>