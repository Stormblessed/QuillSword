<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	require_once("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$character_table = 'characters';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $project->InternalProjectId();
	
	$character_id  = $project->ProjectMappings->CharacterMappings()->Internalize($_POST['character_id']);
	$short_name    = \Crypt::Encrypt($_POST['short_name'], $_SESSION['crypt_pass']);
	$full_name     = \Crypt::Encrypt($_POST['full_name'], $_SESSION['crypt_pass']);
	$alt_names     = \Crypt::Encrypt($_POST['alt_names'], $_SESSION['crypt_pass']);
	$significance  = \Crypt::Encrypt($_POST['significance'], $_SESSION['crypt_pass']);
	$description   = \Crypt::Encrypt($_POST['description'], $_SESSION['crypt_pass']);
	
	$current_time = $_POST['current_time'];
	$current_time = date("Y-m-d H:i:s", strtotime($current_time));
		
	mysql_query("UPDATE 
					$character_table 
				SET 
					short_name = '$short_name',
					full_name = '$full_name',
					alt_names = '$alt_names',
					significance = '$significance',
					description = '$description',
					last_edited = '$current_time'
				WHERE id = '$character_id'
				AND   userid = '$user_id'
				AND   projectid = '$project_id'"
				) or die(mysql_error());
?>