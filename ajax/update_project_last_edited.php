<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	
	$projects_table = 'projects';
	
	$user = new User($_SESSION['userid']);
	
	$user_id        = $user->UserId();
	$project_id     = $user->UserMappings()->ProjectMappings()->Internalize($_SESSION['project_id']);
	
	$current_time = $_POST['current_time'];
	$current_time = date("Y-m-d H:i:s", strtotime($current_time));
						
	mysql_query("UPDATE 
					$projects_table 
				SET 
					last_edited = '$current_time'
				WHERE userid = '$user_id'
				AND   id = '$project_id'"
				) or die(mysql_error());
?>