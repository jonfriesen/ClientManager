<?php 
	require_once('include.php');

	$customer = null;
	$customers = null;
	if(isset($_GET["customer-id"]))
	{
		$cid = $_GET["customer-id"];
		$customer = Customer::GetCustomer($cid);
		$serviceCalls = ServiceCall::GetServiceCallsByCustomerId($cid);
	}
	else if(isset($_GET["customer-name"]))
	{
		$customerName = $_GET["customer-name"];
		$customers = Customer::CustomerSearch($customerName);
		
		if(sizeof($customers) == 1)
		{
			$url = '/customers.php?customer-id='.$customers[0]->getCustomerId();
			header('Location: '.$url);
		}
		else if(sizeof($customers) == 0)
			$customers = null;
	}
	else
	{
		$customers = Customer::GetAllCustomers();
	}
	
	require_once('Header.php');
	
	if(is_object($customer))
	{
?>
	<div class="details">
		<div class="h"><?php echo $customer->getFirstName().' '.$customer->getLastName() ?>:</div>
		<div class="fields">
			Street Address:<br />
			City:<br />
			Province:<br />
			<br />
			Phone Number: <br />
			Email Address:
		</div>
		<div class="values">
			<?php 
			echo $customer->getStreetAddress().'<br />';
			echo $customer->getCity().'<br />';
			echo $customer->getProvince().'<br />';
			echo '<br />';
			echo $customer->getPhoneNumber().'<br />';
			echo $customer->getEmailAddress();
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
					<th>Technician Name</th>
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
							$technicianLink = '<a href="technicians.php?technician-id='.$sc->getTechnicianId().'">'.$sc->getTechnicianName().'</a>';
						
							echo '<tr>';
								echo '<td class="id-cell">'.$sc->getServiceCallId().'</td>';
								echo '<td>'.$technicianLink.'</td>';
								echo '<td>'.date_format($sc->getDate(), 'jS, F Y').'</td>';
							echo '</tr>';
						}
					}
					else
					{
						echo '<td style="text-align:center;" colspan="4">No service calls found for this customer</td>';
					}
				?>
			</tbody>
		</table>
	</div>
<?php
	}	
	else if(is_array($customers))
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
				<th>Phone Number</th>
				<th>Email Address</th>
			</tr>
		</thead>
		<tbody>
			<?php
				global $customers;
				for($i = 0; $i < sizeof($customers); $i++)
				{
					$c = $customers[$i];
					$customerLink = '<a href="customers.php?customer-id='.$c->getCustomerId().'">'.$c->getCustomerId().'</a>';
					echo '<tr>';
						echo '<td class="id-cell">'.$customerLink.'</td>';
						echo '<td>'.$c->getFirstName().'</td>';
						echo '<td>'.$c->getLastName().'</td>';
						echo '<td>'.$c->getStreetAddress().'</td>';
						echo '<td>'.$c->getCity().'</td>';
						echo '<td>'.$c->getProvince().'</td>';
						echo '<td>'.$c->getPhoneNumber().'</td>';
						echo '<td>'.$c->getEmailAddress().'</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">
					<a href="new-customer.php" class="greybox">Add New Customer</a>
				</td>
			</tr>
		</tfoot>
	</table>
<?php
	}
	else
	{
?>
	<div class="message">
		No customers found that matched &quot;<?php echo $customerName; ?>&quot;
	</div>
<?php
	}
?>



<?php 
	require_once('Footer.php');	
?>