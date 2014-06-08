<?php
	require_once("include.php");
	$customers = Customer::GetAllCustomers();
	$technicians = Technician::GetAllTechnicians();
	
	$messages = array();
	if($_POST)
	{
		$tId = $_POST['technician'];
		$cId = $_POST['customer'];
		$date = $_POST['date'];
		$notes = $_POST['notes'];
		
		if($tId == null || $tId == '')
			array_push($messages, 'You must select a valid technician');
		if($cId == null || $cId == '')
			array_push($messages, 'You must select a valid customer');
		if($date == null || $date == '')
			array_push($messages, 'You must select a valid date');
		else
		{
			$s = split('/', $date);
			$date = $s[2].'-'.$s[1].'-'.$s[0];
		}
		
		if($notes == null || $notes == '')
			array_push($messages, 'You must enter some notes for this service call');
			
		if(sizeof($messages) == 0)
		{
			ServiceCall::CreateServiceCall($tId, $cId, $date, $notes);
			array_push($messages, 'Service Call Created');
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
						Technician:
					</div>
					<div class="input">
						<select name="technician">
							<?php
								global $technicians;
								global $tId;
								for($i = 0; $i < sizeof($technicians); $i++)
								{
									if($technicians[$i]->getTechnicianId() == $tId)
										echo '<option value="'.$technicians[$i]->getTechnicianId().'" selected="selected">'.$technicians[$i]->getIndexName().'</option>';
									else
										echo '<option value="'.$technicians[$i]->getTechnicianId().'">'.$technicians[$i]->getIndexName().'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Customer:
					</div>
					<div class="input">
						<select name="customer">
						<?php
							global $cId;
							global $customers;
							for($i = 0; $i < sizeof($customers); $i++)
							{
								if($cId == $customers[$i]->getCustomerId())
									echo '<option value="'.$customers[$i]->getCustomerId().'" selected="selected">'.$customers[$i]->getIndexName().'</option>';
								else
									echo '<option value="'.$customers[$i]->getCustomerId().'">'.$customers[$i]->getIndexName().'</option>';
							}
						?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="prompt">
						Date:
					</div>
					<div class="input">
						<?php
							global $date;
							echo '<input type="text" class="datepicker" name="date" value="'.$date.'" />';
						?>
					</div>
				</div>
				<div class="field">
					<?php 
						global $notes;
						echo '<textarea class="ta-clear", name="notes">'.$notes.'</textarea>';
					?>
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
</html