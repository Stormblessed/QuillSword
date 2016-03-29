<?php	
	include("../processes/connect.php");
	include("../objects/User.php");
	include("../objects/Project.php");
	require_once("../objects/Crypt.php");
	
	$character_table = 'characters';
	
	$user = new User($_SESSION['userid']);
	$project = Project::WithExternalId($_SESSION['project_id']);
	
	$user_id        = $user->UserId();
	$project_id     = $user->UserMappings()->ProjectMappings()->Internalize($_SESSION['project_id']);
	$character_id   = $project->ProjectMappings->CharacterMappings()->Internalize($_POST['character_id']);
	
	$data = mysql_query(
				"SELECT 
					short_name,
					full_name,
					alt_names,
					description,
					significance 
				 FROM 
				 	$character_table 
				 WHERE 
				 	 userid    = '$user_id'
				 AND projectid = '$project_id'
				 AND id        = '$character_id'") or die(mysql_error());
	
	$list = mysql_fetch_array($data);
	
	$decrypted = array();
	
	if($list['short_name'] == "") 
		$decrypted['short_name'] = $list['short_name'];
	else
		$decrypted['short_name'] = \Crypt::Decrypt($list['short_name'], $_SESSION['crypt_pass']);
	
	if($list['full_name'] == "") 
		$decrypted['full_name'] = $list['full_name'];
	else
		$decrypted['full_name'] = \Crypt::Decrypt($list['full_name'], $_SESSION['crypt_pass']);
	
	if($list['alt_names'] == "") 
		$decrypted['alt_names'] = $list['alt_names'];
	else
		$decrypted['alt_names'] = \Crypt::Decrypt($list['alt_names'], $_SESSION['crypt_pass']);
		
	if($list['description'] == "") 
		$decrypted['description'] = $list['description'];
	else
		$decrypted['description'] = \Crypt::Decrypt($list['description'], $_SESSION['crypt_pass']);
		
	if($list['significance'] == "") 
		$decrypted['significance'] = $list['significance'];
	else
		$decrypted['significance'] = \Crypt::Decrypt($list['significance'], $_SESSION['crypt_pass']);
	
	echo json_encode($decrypted);
?>