<?php
class Technician
{
	private $technicianId;
	public function getTechnicianId(){return $this->technicianId;}
	private $userName;
	public function getUserName(){return $this->userName;}
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
	
	private $homePhoneNumber;
	public function getHomePhoneNumber(){return $this->homePhoneNumber;}
	private $mobilePhoneNumber;
	public function getMobilePhoneNumber(){return $this->mobilePhoneNumber;}
	private $primaryEmailAddress;
	public function getPrimaryEmailAddress(){return $this->primaryEmailAddress;}
	private $secondaryEmailAddress;
	public function getSecondaryEmailAddress(){return $this->secondaryEmailAddress;}
	
	private $roles = null;
	public function isInRole($role)
	{
		if($this->roles == null)
			$this->roles = Technician::GetTechnicianRoles($this);
		return isset($this->roles[$role]);
	}
	
	/* Static Data Functions */
	private static function GetTechnicianObject($data)
	{
		$t = new Technician();
		$t->technicianId = $data->TechnicianId;
		$t->userName = $data->UserName;
		$t->firstName = $data->FirstName;
		$t->lastName = $data->LastName;
		$t->streetAddress = $data->StreetAddress;
		$t->city = $data->City;
		$t->province = $data->Province;
		$t->homePhoneNumber = $data->HomePhoneNumber;
		$t->mobilePhoneNumber = $data->MobilePhoneNumber;
		$t->primaryEmailAddress = $data->PrimaryEmailAddress;
		$t->secondaryEmailAddress = $data->SecondaryEmailAddress;

		return $t;
	}


	public static function GetTechnicianById($id)
	{
		$reader = Connection::ScalarQuery('GetTechnicianById', $id);
		return Technician::GetTechnicianObject($reader);
	}
	public static function GetAllTechnicians()
	{
		$reader = Connection::Query('GetAllTechnicians');
		
		$technicians = array();
		foreach($reader as $item)
		{
			array_push($technicians, Technician::GetTechnicianObject($item));
		}
		
		return $technicians;
	}
	public static function GetTechnicianByCredentials($username, $password)
	{
		$reader = Connection::ScalarQuery('GetTechnicianByCredentials', $username, $password);
		return Technician::GetTechnicianObject($reader);
	}
	public static function ChangePassword(Technician $technician, $oldPassword, $newPassword)
	{
		$rows = Connection::NonQuery('ChangePassword', $technician->getTechnicianId(), $oldPassword, $newPassword);
		return $rows == 1;
	}
	public static function GetTechnicianRoles(Technician $technician)
	{
		$reader = Connection::Query('GetTechnicianRoles', $technician->getTechnicianId());
		$roles = array();
		
		foreach($reader as $item)
		{
			$role = $item->Name;
			$roles[$role] = true;
		}
		
		return $roles;
	}
	public static function CreateTechnician($userName, $firstName, $lastName, $streetAddress, $city, $province, $homePhoneNumber, $mobilePhoneNumber, $primaryEmailAddress, $secondaryEmailAddress)
	{
		$technicianId = Connection::ScalarQuery('InsertTechnician', $userName, $firstName, $lastName, $streetAddress, $city, $province, $homePhoneNumber, $mobilePhoneNumber, $primaryEmailAddress, $secondaryEmailAddress);
		
		$t = new Technician();
		$t->technicianId = $technicianId;
		$t->userName = $userName;
		$t->firstName = $firstName;
		$t->lastName = $lastName;
		$t->streetAddress = $streetAddress;
		$t->city = $city;
		$t->province = $province;
		$t->homePhoneNumber = $homePhoneNumber;
		$t->mobilePhoneNumber = $mobilePhoneNumber;
		$t->primaryEmailAddress = $primaryEmailAddress;
		$t->secondaryEmailAddress = $secondaryEmailAddress;
		
		return $t;
	}
}
?>