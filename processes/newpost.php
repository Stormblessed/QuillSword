<?php
	require_once('connect.php');
	$postTable = 'posts';
	
	$userid = mysql_real_escape_string($_SESSION['userid']);
	$group_name = mysql_real_escape_string($_REQUEST['new_post_location']);
	$content = mysql_real_escape_string($_REQUEST['new_post_textarea']);
	
	if(strlen($content) > 1)
		mysql_query("INSERT INTO $postTable (userid, group_name, content) VALUES ('$userid', '$group_name', '$content')");
	
	header("Location: ../home.php");
?>