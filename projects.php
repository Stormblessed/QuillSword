<?php
	require('processes/connect.php');
	require('objects/Project.php');
	require('objects/User.php');
		
	$userTable = 'users';
	$projectsTable = 'projects';
	
	if(isset($_SESSION['active']))
	{
		$loggedInActivity = $_SESSION['active'];
		if($loggedInActivity == true)
		{
			if(isset($_SESSION['email'])  && isset($_SESSION['password']))
			{
				$loggedInEmail = $_SESSION['email'];
				
				$data = mysql_query("SELECT * FROM $userTable WHERE email = '$loggedInEmail'");
				$user = mysql_fetch_array($data);
				if($user['password'] == $_SESSION['password'])
				{				
					//logged in successfully
					$CurrentUser = new User($_SESSION['userid']);	
					//$UserId = $CurrentUser->UserId();
					$projects = $CurrentUser->Projects();
				}
			}
		}
	}
	else
	{
		$loggedInActivity = false;
		header("Location: index.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Projects : QuillSword</title>
    
     <!-- JS INCLUDES -->
    <script src="js/jquery-1.10.0.min.js"></script>
    <script src="services/instantclick.min.js"></script>
    <script src="services/masonry.pkgd.min.js"></script>
    <script src="js/projects.js"></script>
    <script src="js/read.js"></script>
    <script src="js/home.js"></script>
    <script src="js/groups.js"></script>
    <script src="js/profile.js"></script>
    
    <!-- Web Fonts & stylesheets -->
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Berkshire+Swash' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>

<body>
	<div id="site">
    	<div id="nav">
        	<div id="nav_inner">
            	<div id="nav_logo"><a href="home.php" data-instant>QuillSword</a></div>
                <div id="nav_home" class="nav_link"><a href="home.php" data-instant>Home</a></div>
                <div id="nav_write" class="nav_link  nav_active"><a href="#projects" data-instant>Write</a></div>
                <div id="nav_read" class="nav_link"><a href="read.php" data-instant>Read</a></div>
                <div id="nav_profile" class="nav_link">
                	<div id="nav_profile_pic">
                    	<a href="profile.php"><img id="profile_pic" src="img/default_profile.jpg"/></a>
                    </div>
                    <div id="nav_profile_text">
                		<a href="profile.php"><?php echo $CurrentUser->FullName(); ?></a>
                        <div id="nav_logout">
                        	<a href="processes/logout.php">Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="nav_filler"></div>
        <div id="projects_main">
        	<div id="projects_main_inner">
            	<div id="projects_menu_column">
                	<div id="projects_menu">
                    	<div id="new_projects_button">
                        	<a id="new_projects_button_link" href="#new" onclick="newProjectDropDown()">NEW PROJECT</a>
                        </div>
                        <div id="new_projects_dropdown">
                        	<form action="processes/newproject.php" method="post" enctype="multipart/form-data" name="new_projects_form">
                            	<input id="new_projects_title" class="new_projects_form new_projects_form_text" name="new_projects_title" placeholder="Title" type="text" />
                                <input id="new_projects_genre" class="new_projects_form new_projects_form_text" name="new_projects_genre" placeholder="Genre" type="text" />
                                <textarea id="new_projects_description" class="new_projects_form new_projects_form_text" name="new_projects_description" placeholder="Description"></textarea>
                                <input id="new_projects_submit" class="new_projects_form new_projects_form_button" name="new_projects_submit" type="submit" value="Finish"/>
                                <input id="new_projects_cancel" class="new_projects_form new_projects_form_button" name="new_projects_cancel" onclick="newProjectDropDown()" type="button" value="X"/>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="projects_display_column">
                	<div id="projects_display">
                    	<div id="projects_display_inner">
                            <div id="projects_display_ribbon">
                                <div id="projects_display_ribbon_select" class="projects_display_ribbon_item">#</div>
                                <div id="projects_display_ribbon_title" class="projects_display_ribbon_item">Title</div>
                                <div id="projects_display_ribbon_genre" class="projects_display_ribbon_item">Genre</div>
                                <div id="projects_display_ribbon_status" class="projects_display_ribbon_item">Status</div>
                                <div id="projects_display_ribbon_modified" class="projects_display_ribbon_item">Date Modified</div>
                            </div>
                            <div id="projects_display_main">
								<?php
                                $count = 1;
                                foreach($projects as $project)
                                {
                                    echo '<div class="projects_display_main_project notextselect" onclick="toggleProjectDropDown('.$project->ProjectId().')">
                                             <div class="projects_display_main_select project_display_element">'.$count.'</div>
                                             <div class="projects_display_main_title project_display_element">'.$project->Title().'</div>
                                             <div class="projects_display_main_genre project_display_element">'.$project->Genre().'</div>
                                             <div class="projects_display_main_status project_display_element">'.$project->Status().'</div>
                                             <div class="projects_display_main_modified project_display_element">'.$project->LastEdited().'</div>
                                          </div>';
										  
									echo '<div id="project_dropdown_'.$project->ProjectId().'" class="projects_display_project_content">
											<div class="project_display_content_item">
												<div class="project_display_content_header">Front Cover</div>
												<div class="project_display_content_main">
													<a href="#" class="project_display_cover_image"><img class="project_display_cover_img" src="userdata/covers/front/default.png"/></a>
												</div>
											</div>
											<div class="project_display_content_item">
												<div class="project_display_content_header">Back Cover</div>
												<div class="project_display_content_main">
													<a href="#" class="project_display_cover_image"><img class="project_display_cover_img" src="userdata/covers/front/default.png"/></a>
												</div>
											</div>
											<div class="project_display_content_item">
												<div class="project_display_content_header">Title</div>
												<div id="project_title_'.$project->ProjectId().'" class="project_display_content_main project_display_dual_row project_display_main_text">
													'.$project->Title().'
												</div>
												<div class="project_display_content_header">Genres</div>
												<div id="project_genre_'.$project->ProjectId().'" class="project_display_content_main project_display_dual_row project_display_main_text">
													'.$project->Genre().'
												</div>
											</div>
											<div class="project_display_content_item">
												<div class="project_display_content_header">Description</div>
												<div id="project_description_'.$project->ProjectId().'" class="project_display_content_main project_display_main_text">
													'.$project->Description().'
												</div>
											</div>
											<div class="project_display_content_item">
												<div class="project_display_content_header">Actions</div>
												<div class="project_display_content_main">
													<a href="#" class="projects_display_content_link" onclick="openProject('.$project->ProjectId().'); return false;">Open Project</a>
													<a href="#" class="toggle_project_edit_'.$project->ProjectId().' projects_display_content_link" 
																onclick="ToggleProjectEditing('.$project->ProjectId().'); return false;">
														Edit Project Info
													</a>
													<a href="#" id="save_project_edits" class="save_project_edits_'.$project->ProjectId().' projects_display_content_link"
													            onclick="SaveProjectInfoEdits('.$project->ProjectId().'); return false;">
													Save Edits
													</a>
													<a href="#" class="projects_display_content_link">Publish Project</a>
												</div>
											</div>
										</div>';
                                    $count++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
        	<div id="footer_inner">
            	<div id="footer_social_bar">
                	<div id="footer_social_bar_inner">
                        <div id="social_plus" class="social_button"><a href="#plus" class="social_button" style="border: 0;"></a></div>
                        <div id="social_twitter" class="social_button"><a href="#twitter" class="social_button" style="border: 0;"></a></div>
                        <div id="social_youtube" class="social_button"><a href="#youtube" class="social_button" style="border: 0;"></a></div>
                        <div id="social_facebook" class="social_button"><a href="#facebook" class="social_button" style="border: 0;"></a></div>
                        <div id="social_pinterest" class="social_button"><a href="#pinterest" class="social_button" style="border: 0;"></a></div>
                    </div>
                </div>
                <div id="footer_links_bar">
                	<div id="footer_links_bar_inner">
                        <div id="footer_link_copyright" class="footer_link">© QuillSword 2014</div>
                        <div id="footer_link_about_us" class="footer_link"><a href="#about">About Us</a></div>
                        <div id="footer_link_blog" class="footer_link"><a href="#blog">Blog</a></div>
                        <div id="footer_link_faqs" class="footer_link"><a href="#faqs">FAQs</a></div>
                        <div id="footer_link_contact" class="footer_link"><a href="#mail">Contact</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="closer"></div>
    </div>
</body>
<script data-no-instant>InstantClick.init(true);</script>
</html>