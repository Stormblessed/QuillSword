<?php
	require_once('connect.php');
	require_once('../objects/Emailer.php');
	
	$usersTable = "users";
	
	if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['email']))
	{
		$first_name = mysql_real_escape_string($_POST['first_name']);
		$last_name = mysql_real_escape_string($_POST['last_name']);
		$email = mysql_real_escape_string($_POST['email']);
		$password = $_POST['password'];
	
		$hashed = md5($password);
		$verity_hash = md5(rand(0, 1000));
		
		if(IsUniqueEmail($email))
		{
			mysql_query("INSERT INTO $usersTable (last_name, first_name, password, email, verity_hash) VALUES ('$last_name', '$first_name', '$hashed', '$email', '$verity_hash')");
			\Emailer::SendAccountConfirmationEmail($email, $verity_hash);
			header("Location: ../index.php?msg=Verify your account by clicking the link sent to the email address you provided.");
		}
		else
		{
			header("Location: ../index.php?msg=Account credentials invalid.  The email may not have been unique.");
		}
	}
	else
	{
		header("Location: ../index.php?msg=Account credentials invalid.  The email may not have been unique.");
	}
		
	function IsUniqueEmail($email)
	{
		$usersTable = "users";
		
		$data = mysql_query("SELECT email FROM $usersTable WHERE email='$email'");
		$list = mysql_fetch_array($data);
		return (count($list['email']) < 1);
	}
?>