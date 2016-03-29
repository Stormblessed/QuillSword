<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	require_once("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$scene_table = 'scenes';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $user->UserMappings()->ProjectMappings()->Internalize($_SESSION['project_id']);
	
	$title      = "Chapter";
	$title_enc = \Crypt::Encrypt($title, $_SESSION['crypt_pass']);
				
	mysql_query("INSERT INTO 
					$scene_table 
					(userid, projectid, title)
				VALUES
					('$user_id', '$project_id', '$title_enc')"
				) or die(mysql_error());
				
	$ajax_array = array("title" => $title);
	
	echo json_encode($ajax_array);
?>