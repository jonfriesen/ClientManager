<?php 
	require_once('include.php');
	global $user;
	if(!$user->isInRole('Administrator'))
		header('Location:index.php');
		
	require_once('header.php');
?>
<center>
	<a href="new-technician.php" class="greybox">Add New Technician</a>
</center>
<?php 
	require_once('footer.php');
?>