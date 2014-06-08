<?php
session_start();
global $isLoginPage;
if(!$isLoginPage && !isset($_SESSION['username']))
	header('Location:login.php');

require_once('Data/Data.php');
require_once('Objects/Technician.php');
require_once('Objects/Customer.php');
require_once('Objects/ServiceCall.php');

if(isset($_SESSION['username']))
	$user = Technician::GetTechnicianById($_SESSION['technicianId']);
?>