<?php
require_once("include.php");

$serviceCalls = ServiceCall::GetRecentServiceCalls(40);

require_once("Header.php");
?>

<table cellspacing="0" cellpadding="0" class="c-table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Customer Name</th>
			<th>Technician Name</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for($i = 0; $i < sizeof($serviceCalls); $i++)
			{
				$sc = $serviceCalls[$i];
				$customerLink = '<a href="customers.php?customer-id='.$sc->getCustomerId().'">'.$sc->getCustomerName().'</a>';
				$technicianLink = '<a href="technicians.php?technician-id='.$sc->getTechnicianId().'">'.$sc->getTechnicianName().'</a>';
				
				echo '<tr>';
					echo '<td class="id-cell">'.$serviceCalls[$i]->getServiceCallId().'</td>';
					echo '<td>'.$customerLink.'</td>';
					echo '<td>'.$technicianLink.'</td>';
					echo '<td>'.date_format($serviceCalls[$i]->getDate(), 'jS, F Y').'</td>';
				echo '</tr>';
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<a href="new-service-call.php" class="greybox">New Service Call</a>
			</td>
		</tr>
	</tfoot>
</table>

<?php 
require_once("Footer.php");
?>
