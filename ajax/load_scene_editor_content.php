<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	include("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$scene_table = 'scenes';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $user->UserMappings()->ProjectMappings()->Internalize($_SESSION['project_id']);
	$scene_id       = $project->ProjectMappings->SceneMappings()->Internalize($_POST['scene_id']);
	
	$data = mysql_query(
				"SELECT 
					title,
					content 
				 FROM 
				 	$scene_table 
				 WHERE 
				 	 userid = '$user_id'
				 AND projectid = '$project_id'
				 AND id = '$scene_id'") or die(mysql_error());
	
	$list = mysql_fetch_assoc($data);
	
	$decrypted = array();
	
	if($list['title'] == "") 
		$decrypted['title'] = $list['title'];
	else
		$decrypted['title'] = \Crypt::Decrypt($list['title'], $_SESSION['crypt_pass']);
		
	if($list['content'] == "")
		$decrypted['content'] = $list['content'];
	else
		$decrypted['content'] = \Crypt::Decrypt($list['content'], $_SESSION['crypt_pass']);
	
	echo json_encode($decrypted);
?>