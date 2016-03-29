<?php
	require_once('../processes/connect.php');
	require_once('../objects/User.php');
	
	$followsTable = 'follows';
	
	$CurrentUser = new User(mysql_real_escape_string($_SESSION['userid']));
	$userid = $CurrentUser->UserId();
	$target_id = mysql_real_escape_string($_REQUEST['target_id']);
	
	if(!$CurrentUser->IsFollowingUser($target_id))
		mysql_query("INSERT INTO $followsTable (userid, target_id) VALUES ('$userid', '$target_id')");
	else
		mysql_query("DELETE FROM $followsTable WHERE userid='$userid' AND target_id='$target_id'");	
?>