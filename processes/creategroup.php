<?php
	require_once('connect.php');
	
	$groupsTable = 'groups';
	
	$userid = mysql_real_escape_string($_SESSION['userid']);
	$group_title = mysql_real_escape_string($_REQUEST['create_group_title']);
	$group_description = mysql_real_escape_string($_REQUEST['create_group_description']);
	
	mysql_query("INSERT INTO $groupsTable (creator_id, name, description, type) VALUES ('$userid', '$group_title', '$group_description', 'Standard')");
	
	header("Location: ../groups.php");
?>