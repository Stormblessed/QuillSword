<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	
	$projectsTable   = 'projects';
	
	$user        = new User($_SESSION['userid']);
	
	$user_id     = $user->UserId();
	
	$project_id  = $user->UserMappings()->ProjectMappings()->Internalize(mysql_real_escape_string($_POST['project_id']));
	$title       = mysql_real_escape_string($_POST['title']);
	$genres      = mysql_real_escape_string($_POST['genres']);
	$description = mysql_real_escape_string($_POST['description']);
		  
	mysql_query("UPDATE 
					$projectsTable 
				SET 
					title = '$title',
					genre = '$genres',
					description = '$description'
				WHERE id = '$project_id' AND
				      userid = '$user_id'"
				) or die(mysql_error());
?>