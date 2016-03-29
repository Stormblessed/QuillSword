<?php

	require_once('connect.php');
	require_once("../objects/Crypt.php");
	
	$projectsTable = "projects";
	$scenesTable = "scenes";
	
	$userid = $_SESSION['userid'];
	$title = mysql_real_escape_string($_POST['new_projects_title']);
	$genre = mysql_real_escape_string($_POST['new_projects_genre']);
	$description = mysql_real_escape_string($_POST['new_projects_description']);
	$privacy = "Private";
	$status = "In-Progress";
		
	//add project to database
	mysql_query("INSERT INTO $projectsTable (userid, title, genre, description, privacy, status) VALUES ('$userid', '$title', '$genre', '$description', '$privacy', '$status')");
	
	//add first scene to project
	$project_id = mysql_insert_id();
	$title_enc = \Crypt::Encrypt("Chapter", $_SESSION['crypt_pass']);
	mysql_query("INSERT INTO 
					$scenesTable 
					(userid, projectid, title)
				VALUES
					('$userid', '$project_id', '$title_enc')"
				) or die(mysql_error());
	
	header("Location: ../projects.php");

?>