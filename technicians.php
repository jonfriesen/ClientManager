<?php 
	require_once("include.php");
	
	$technician = null;
	$technicians = null;
	
	if(isset($_GET["technician-id"]))
	{
		$tid = $_GET["technician-id"];
		$technician = Technician::GetTechnicianById($tid);
		$serviceCalls = ServiceCall::GetServiceCallsByTechnicianId($tid);
	}
	else
	{
		$technicians = Technician::GetAllTechnicians();
	}

	require_once("Header.php");
	
	if(is_object($technician))
	{
?>
	<div class="details">
		<div class="h"><?php echo $technician->getFirstName().' '.$technician->getLastName() ?>:</div>
		<div class="fields">
			Street Address:<br />
			City:<br />
			Province:<br />
			<br />
			Home Phone Number: <br />
			Mobile Phone Number: <br />
			Primary Email Address: <br />
			Secondary Email Address:
		</div>
		<div class="values">
			<?php 
			echo $technician->getStreetAddress().'<br />';
			echo $technician->getCity().'<br />';
			echo $technician->getProvince().'<br />';
			echo '<br />';
			echo $technician->getHomePhoneNumber().'<br />';
			echo $technician->getMobilePhoneNumber().'<br />';
			echo $technician->getPrimaryEmailAddress().'<br />';
			echo $technician->getSecondaryEmailAddress();
			?>
		</div>
	</div>
	<div class="details-table">
		<div class="h">
			Service Calls:
		</div>
		<table cellspacing="0" cellpadding="0" class="c-table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Customer Name</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(sizeof($serviceCalls) > 0)
					{ 
						for($i = 0; $i < sizeof($serviceCalls); $i++)
						{
							$sc = $serviceCalls[$i];
							$customerLink = '<a href="customers.php?customer-id='.$sc->getCustomerId().'">'.$sc->getCustomerName().'</a>';
						
							echo '<tr>';
								echo '<td class="id-cell">'.$sc->getServiceCallId().'</td>';
								echo '<td>'.$customerLink.'</td>';
								echo '<td>'.date_format($sc->getDate(), 'jS, F Y').'</td>';
							echo '</tr>';
						}
					}
					else
					{
						echo '<td style="text-align:center;" colspan="4">No service calls found for this technician</td>';
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<?php
							echo '<a class="greybox" href="new-service-call.php?technician-id='.$technician->getTechnicianId().'">Add New Service Call</a>';
						?>
					</td>
			</tfoot>
		</table>
	</div>
<?php 
	}
	else if(is_array($technicians))
	{
?>

	<table cellspacing="0" cellpadding="0" class="c-table">
		<thead>
			<tr>
				<th>Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Street Address</th>
				<th>City</th>
				<th>Province</th>
				<th>Home Phone Number</th>
				<th>Mobile Phone Number</th>
				<th>Email Address</th>
			</tr>
		</thead>
		<tbody>
			<?php
				global $technicians;
				for($i = 0; $i < sizeof($technicians); $i++)
				{
					$t = $technicians[$i];
					$technicianLink = '<a href="technicians.php?technician-id='.$t->getTechnicianId().'">'.$t->getTechnicianId().'</a>';
					echo '<tr>';
						echo '<td class="id-cell">'.$technicianLink.'</td>';
						echo '<td>'.$t->getFirstName().'</td>';
						echo '<td>'.$t->getLastName().'</td>';
						echo '<td>'.$t->getStreetAddress().'</td>';
						echo '<td>'.$t->getCity().'</td>';
						echo '<td>'.$t->getProvince().'</td>';
						echo '<td>'.$t->getHomePhoneNumber().'</td>';
						echo '<td>'.$t->getMobilePhoneNumber().'</td>';
						echo '<td>'.$t->getPrimaryEmailAddress().'</td>';
					echo '</tr>';
				}
			?>
		</tbody>
	</table>
<?php 
	}
	require_once("Footer.php");
?>