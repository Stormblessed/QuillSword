<?php
	require_once('../processes/connect.php');
	require_once('../objects/User.php');
	
	$savedGroupsTable = 'saved_groups';
	
	$CurrentUser = new User(mysql_real_escape_string($_SESSION['userid']));
	$userid = $CurrentUser->UserId();
	$group_id = mysql_real_escape_string($_REQUEST['group_id']);
		
	if(!$CurrentUser->IsFollowingGroup($group_id))
		mysql_query("INSERT INTO $savedGroupsTable (userid, group_id) VALUES ('$userid', '$group_id')");
	else
		mysql_query("DELETE FROM $savedGroupsTable WHERE userid='$userid' AND group_id='$group_id'");
?>