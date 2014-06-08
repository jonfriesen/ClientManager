<html>	
	<head>
		<title>Client Manager</title>
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
		<div id="header">
			<div id="nav">
				<ul>
					<li><a href="service-calls.php">Service Calls</a></li>
					<li><a href="customers.php">Customers</a></li>
					<li><a href="technicians.php">Technicians</a></li>
					<?php 
						global $user;
						if($user->isInRole('Administrator'))
							echo '<li><a href="security.php">Settings</a></li>';
					?>
					<li><a href='login.php?action=logout'>Logout</a></li>
				</ul>
			</div>
			<div id="customer-search">
				<span>Search:</span>
				<span><input type="text" id="cust_name" name="cust_name" class="clear-on-focus" value="Customer Name" /></span>
				<span><a href="#" onclick="customerSearch()">Go</a></span>
			</div>
		</div>
		<div id="content">