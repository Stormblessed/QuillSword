<?php
	include("../processes/connect.php");
	include("../objects/User.php");
	include("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$location_table = 'locations';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $user->UserMappings()->ProjectMappings()->Internalize($_SESSION['project_id']);
	$location_id    = $project->ProjectMappings->LocationMappings()->Internalize($_POST['location_id']);
	
	$data = mysql_query(
				"SELECT 
					title,
					alt_titles,
					description 
				 FROM 
				 	$location_table 
				 WHERE 
				 	 userid    = '$user_id'
				 AND projectid = '$project_id'
				 AND id        = '$location_id'") or die(mysql_error());
	
	$list = mysql_fetch_array($data);
	
	$decrypted = array();
	
	if($list['title'] == "") 
		$decrypted['title'] = $list['title'];
	else
		$decrypted['title'] = \Crypt::Decrypt($list['title'], $_SESSION['crypt_pass']);
		
	if($list['alt_titles'] == "") 
		$decrypted['alt_titles'] = $list['alt_titles'];
	else
		$decrypted['alt_titles'] = \Crypt::Decrypt($list['alt_titles'], $_SESSION['crypt_pass']);
		
	if($list['description'] == "") 
		$decrypted['description'] = $list['description'];
	else
		$decrypted['description'] = \Crypt::Decrypt($list['description'], $_SESSION['crypt_pass']);
	
	echo json_encode($decrypted);
?>