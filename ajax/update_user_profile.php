<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	
	$userTable = 'users';
	
	$user = new User($_SESSION['userid']);
	
	$user_id        = $user->UserId();
	
	$description = mysql_real_escape_string($_POST['description']);
	$genres = mysql_real_escape_string($_POST['genres']);
	$books = mysql_real_escape_string($_POST['books']);
	$authors = mysql_real_escape_string($_POST['authors']);
						  	  
	mysql_query("UPDATE 
					$userTable 
				SET 
					description = '$description',
					genres = '$genres',
					books = '$books',
					authors = '$authors'
				WHERE id = '$user_id'"
				) or die(mysql_error());
?>