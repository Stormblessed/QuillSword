<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	require_once("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$scene_table = 'scenes';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $project->InternalProjectId();
	
	$scene_id    = $project->ProjectMappings->SceneMappings()->Internalize($_POST['scene_id']);
	$title       = \Crypt::Encrypt($_POST['title'], $_SESSION['crypt_pass']);
	$content     = \Crypt::Encrypt($_POST['scene_content'], $_SESSION['crypt_pass']);
		
	$current_time = $_POST['current_time'];
	$current_time = date("Y-m-d H:i:s", strtotime($current_time));
			  	  
	mysql_query("UPDATE 
					$scene_table 
				SET 
					title = '$title',
					content = '$content',
					last_edited = '$current_time'
				WHERE id = '$scene_id'
				AND   userid = '$user_id'
				AND   projectid = '$project_id'"
				) or die(mysql_error());
?>