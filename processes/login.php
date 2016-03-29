<?php
	include('connect.php');
	//include('../objects/User.php');
	
	$tableName = "users";
	$_SESSION['login_error'] = "login_error";
	
	//process login
	$email = $_POST['email'];
	$password = $_POST['password'];
	$hashed = md5($password);
	
	//Get User	
	$data = mysql_query("SELECT * FROM $tableName WHERE email = '$email'");
	$list = mysql_fetch_array($data);
	
	if($hashed == $list['password'])
	{
		if($list['active'] == "true")
		{
			session_start();
			$_SESSION['active'] = true;
			$_SESSION['userid'] = $list['id'];
			$_SESSION['email'] = $email;
			$_SESSION['password'] = $hashed;
			
			header("Location: ../home.php");
		}
		else
		{
			header("Location: ../index.php?msg=Account not activated.");
		}
	}
	else
	{	
		$_SESSION['login_error'] = "login_error";
		header("Location: ../index.php?msg=Invalid login credentials.");
	}
	
?>