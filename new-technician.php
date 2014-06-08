<?php
	require_once("include.php");

	global $user;
	if(!$user->isInRole('Administrator'))
		header("Location:index.php");
	
	$messages = array();
	if($_POST)
	{
		$userName = $_POST["username"];
		$firstName = $_POST["firstname"];
		$lastName = $_POST["lastname"];
		$streetAddress = $_POST["streetaddress"];
		$city = $_POST["city"];
		$province = $_POST["province"];
		$homePhoneNumber = $_POST["homephonenumber"];
		$mobilePhoneNumber = $_POST["mobilephonenumber"];
		$primaryEmailAddress = $_POST["primaryemailaddress"];
		$secondaryEmailAddress = $_POST["secondaryemailaddress"];
		
		if($userName == null || $userName == '')
			array_push($messages, 'You must enter a user name for the technician');
		if($firstName == null || $firstName == '')
			array_push($messages, 'You must enter a first name for the technician');
		if($lastName == null || $lastName == '')
			array_push($messages, 'You must enter a last name for the technician');
		if($streetAddress == null || $streetAddress == '')
			array_push($messages, 'You must enter a street address for the technician');
		if($city == null || $city == '')
			array_push($messages, 'You must enter a city for the technician');
		if($province == null || $province == '')
			array_push($messages, 'You must enter a province for the technician');
		if($homePhoneNumber == null || $homePhoneNumber == '')
			array_push($messages, 'You must enter a home phone number for the technician');
		if($primaryEmailAddress == null || $primaryEmailAddress == '')
			array_push($messages, 'You must enter an email address for the technician');
				
		if(sizeof($messages) == 0)
		{
			Technician::CreateTechnician($userName, $firstName, $lastName, $streetAddress, $city, $province, $homePhoneNumber, $mobilePhoneNumber, $primaryEmailAddress, $secondaryEmailAddress);
			array_push($messages, 'Technician Created');
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
						User Name:
					</div>
					<div class="input">
						<?php 
							global $userName;
							echo '<input type="text" name="username" value="'.$userName.'" />';
						?>
					</div>
				</div>
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
						Home Phone Number:
					</div>
					<div class="input">
						<?php 
							global $homePhoneNumber;
							echo '<input type="text" name="homephonenumber" value="'.$homePhoneNumber.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Mobile Phone Number:
					</div>
					<div class="input">
						<?php 
							global $mobilePhoneNumber;
							echo '<input type="text" name="mobilephonenumber" value="'.$mobilePhoneNumber.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Primary Email Address:
					</div>
					<div class="input">
						<?php 
							global $primaryEmailAddress;
							echo '<input type="text" name="primaryemailaddress" value="'.$primaryEmailAddress.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Secondary Email Address:
					</div>
					<div class="input">
						<?php 
							global $secondaryEmailAddress;
							echo '<input type="text" name="secondaryemailaddress" value="'.$secondaryEmailAddress.'" />';
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