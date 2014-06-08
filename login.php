<?php
	$isLoginPage = true;
	require_once('include.php');

	if(isset($_GET['action']) && $_GET['action'] == 'logout')
	{
		session_unset();
	}
	
	if($_POST)
	{
		$messages = array();
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$technician = Technician::GetTechnicianByCredentials($username, $password);
                
		if($technician == null)
			array_push($messages, 'Invalid Credentials');
		else
		{
			$_SESSION['username'] = $username;
			$_SESSION['technicianId'] = $technician->getTechnicianId();
			header('Location:index.php');
		}
	}
?>
<html>
	<head>
		<title>Login</title>
		<link type="text/css" rel="stylesheet" href="Styles/styles.css" />
	</head>
	<body>
		<form method="POST" action="">
			<table class=".c-table">
				<tr>
					<td class="h" colspan="2">
						Login
					</td>
				</tr>
				<tr>
					<td>
						Username:
					</td>
					<td>
						<input type="text" name="username" />
					</td>
				</tr>
				<tr>
					<td>
						Password:
					</td>
					<td>
						<input type="password" name="password" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Submit" />
					</td>
				</tr>
				<?php 
					global $messages;
					if(sizeof($messages) > 0)
					{				
						echo '<tr><td colspan="2">';
						for($i = 0; $i < sizeof($messages); $i++)
						{
							echo '<div class="message">'.$messages[$i].'</div>';
						}
						echo '</td></tr>';
					}
				?>
			</table>	
		</form>
	</body>
</html>