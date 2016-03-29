<?php
	require_once('connect.php');
	
	$usersTable = "users";
	
	if(isset($_GET['email']) && isset($_GET['hash']))
	{
		$email = $_GET['email'];
		$hash = $_GET['hash'];
				
		$data = mysql_query("SELECT verity_hash FROM $usersTable WHERE email='$email'");
		$list = mysql_fetch_array($data);
		
		if($list['verity_hash'] == $hash)
		{
			mysql_query("UPDATE $usersTable SET active='true' WHERE email='$email'");
			header("Location: ../index.php?msg=Your account has been activated.");
		}
		else
		{
			header("Location: ../index.php?msg=Account activation failed.");
		}
	}
	else
	{
		header("Location: ../index.php?msg=Account activation failed.");
	}
?>