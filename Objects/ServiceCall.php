<?php
class ServiceCall
{
	private $serviceCallId;
	public function getServiceCallId(){return $this->serviceCallId;}
	
	private $technicianId;
	public function getTechnicianId(){return $this->technicianId;}
	
	private $technicianName;
	public function getTechnicianName(){return $this->technicianName;}
	
	private $customerId;
	public function getCustomerId(){return $this->customerId;}
	
	private $customerName;
	public function getCustomerName(){return $this->customerName;}
	
	private $date;
	public function getDate(){return $this->date;}
	
	private $notes;
	public function getNotes(){return $this->notes;}
	
	/* static data methods */
	private static function getServiceCallObject($reader)
	{
		$sc = new ServiceCall();
		$sc->serviceCallId = $reader->ServiceCallId;
		$sc->technicianId = $reader->TechnicianId;
		$sc->technicianName = $reader->TechnicianName;
		$sc->customerId = $reader->CustomerId;
		$sc->customerName = $reader->CustomerName;
		$sc->date = new DateTime($reader->Date);
		$sc->notes = $reader->Notes;
		return $sc;
	}
	public static function GetServiceCall($id)
	{
		$reader = Connection::ScalarQuery('GetServiceCall', $id);
		return ServiceCall::getServiceCallObject($reader);		
	}
	public static function GetRecentServiceCalls($count)
	{
		$reader = Connection::Query('GetRecentServiceCalls', $count);
		$serviceCalls = array();
		
		foreach($reader as $item)
		{
			array_push($serviceCalls, ServiceCall::getServiceCallObject($item));
		}
		return $serviceCalls;	
	}
	public static function GetServiceCallsByCustomerId($cid)
	{
		$reader = Connection::Query('GetServiceCallsByCustomerId', $cid);
		$serviceCalls = array();
		
		foreach($reader as $item)
		{
			array_push($serviceCalls, ServiceCall::getServiceCallObject($item));
		}
		return $serviceCalls;
	}
	public static function GetServiceCallsByTechnicianId($tid)
	{	
		$reader = Connection::Query('GetServiceCallsByTechnicianId', $tid);
		$serviceCalls = array();
		
		foreach($reader as $item)
		{
			array_push($serviceCalls, ServiceCall::getServiceCallObject($item));
		}
		return $serviceCalls;
	}
	public static function CreateServiceCall($technicianId, $customerId, $date, $notes)
	{
		$serviceCallId = Connection::ScalarQuery('InsertServiceCall', $technicianId, $customerId, $date, $notes);
		
		$sc = new ServiceCall();
		$sc->serviceCallId = $serviceCallId;
		$sc->technicianId = $technicianId;
		$sc->customerId = $customerId;
		$sc->date = $date;
		$sc->notes = $notes;
		
		return $sc;
	}
}
?>