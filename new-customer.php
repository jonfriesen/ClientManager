<?php
	require_once("include.php");
	$customers = Customer::GetAllCustomers();
	$technicians = Technician::GetAllTechnicians();
	
	$messages = array();
	if($_POST)
	{
		$firstName = $_POST["firstname"];
		$lastName = $_POST["lastname"];
		$streetAddress = $_POST["streetaddress"];
		$city = $_POST["city"];
		$province = $_POST["province"];
		$phoneNumber = $_POST["phonenumber"];
		$emailAddress = $_POST["emailaddress"];
		
		if($firstName == null || $firstName == '')
			array_push($messages, 'You must enter a first name for the customer');
		if($lastName == null || $lastName == '')
			array_push($messages, 'You must enter a last name for the customer');
		if($streetAddress == null || $streetAddress == '')
			array_push($messages, 'You must enter a street address for the customer');
		if($city == null || $city == '')
			array_push($messages, 'You must enter a city for the customer');
		if($province == null || $province == '')
			array_push($messages, 'You must enter a province for the customer');
		if($phoneNumber == null || $phoneNumber == '')
			array_push($messages, 'You must enter a phone number for the customer');
		if($emailAddress == null || $emailAddress == '')
			array_push($messages, 'You must enter an email address for the customer');
				
		if(sizeof($messages) == 0)
		{
			Customer::CreateCustomer($firstName, $lastName, $streetAddress, $city, $province, $phoneNumber, $emailAddress);
			array_push($messages, 'Customer Created');
		}
	}
?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="Styles/styles.css" />
		<link type="text/css" rel="stylesheet" href="Greybox/greybox.css" />
		<link type="text/css" rel="stylesheet" href="Styles/datepicker.css" />
		<script type="text/javascript" src="Styles/jquery.js" ></script>
		<script type="text/javascript" src="Greybox/greybox.js"></script>
		<script type="text/javascript" src="Styles/datepicker.js"></script>
		<script type="text/javascript" src="Styles/date-methods.js"></script>
		<script type="text/javascript" src="Styles/template.js"></script>		
	</head>
	<body>
		<form method="post" action="">
			<div class="form">
				<div class="field">
					<div class="prompt">
						First Name:
					</div>
					<div class="input">
						<?php 
							global $firstName;
							echo '<input type="text" name="firstname" value="'.$firstName.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Last Name:
					</div>
					<div class="input">
						<?php 
							global $lastName;
							echo '<input type="text" name="lastname" value="'.$lastName.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Street Address:
					</div>
					<div class="input">
						<?php 
							global $streetAddress;
							echo '<input type="text" name="streetaddress" value="'.$streetAddress.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						City:
					</div>
					<div class="input">
						<?php 
							global $city;
							echo '<input type="text" name="city" value="'.$city.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Province:
					</div>
					<div class="input">
						<?php 
							global $province;
							echo '<input type="text" name="province" value="'.$province.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Phone Number:
					</div>
					<div class="input">
						<?php 
							global $phoneNumber;
							echo '<input type="text" name="phonenumber" value="'.$phoneNumber.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Email Address:
					</div>
					<div class="input">
						<?php 
							global $emailAddress;
							echo '<input type="text" name="emailaddress" value="'.$emailAddress.'" />';
						?>
					</div>
				</div>
				<div class="submit">
					<input type="submit" name="submit" value="Insert" />
				</div>
				<?php
				global $messages; 
				if($messages != null)
				{
					echo '<div class="messages">';
					for($i = 0; $i < sizeof($messages); $i++)
					{
						echo '<div class="message">'.$messages[$i].'</div>';
					}
					echo '</div>';
				}
				?>
			</div>
		</form>
	</body>
</html>