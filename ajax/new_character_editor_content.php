<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	require_once("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$character_table = 'characters';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $user->UserMappings()->ProjectMappings()->Internalize($_SESSION['project_id']);
	
	$full_name     = "Not yet named.";
	$full_name_enc = \Crypt::Encrypt($full_name, $_SESSION['crypt_pass']);
		
	mysql_query("INSERT INTO 
					$character_table 
					(userid, projectid, full_name)
				VALUES
					('$user_id', '$project_id', '$full_name_enc')"
				) or die(mysql_error());
				
	$ajax_array = array("name" => $full_name);
	
	echo json_encode($ajax_array);
?>