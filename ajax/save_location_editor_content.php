<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	require_once("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$location_table = 'locations';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $project->InternalProjectId();
	
	$location_id    = $project->ProjectMappings->LocationMappings()->Internalize($_POST['location_id']);
	$title          = \Crypt::Encrypt($_POST['title'], $_SESSION['crypt_pass']);
	$alt_titles     = \Crypt::Encrypt($_POST['alt_titles'], $_SESSION['crypt_pass']);
	$description    = \Crypt::Encrypt($_POST['description'], $_SESSION['crypt_pass']);
	
	$current_time = $_POST['current_time'];
	$current_time = date("Y-m-d H:i:s", strtotime($current_time));
	
	mysql_query("UPDATE 
					$location_table 
				SET 
					title = '$title',
					alt_titles = '$alt_titles',
					description = '$description',
					last_edited = '$current_time'
				WHERE id = '$location_id'
				AND   userid = '$user_id'
				AND   projectid = '$project_id'"
				) or die(mysql_error());
?>