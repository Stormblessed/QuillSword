<?php
	include('processes/connect.php');	
	require_once('objects/User.php');
	require_once('objects/Project.php');
	
	$userTable = 'users';
	$postTable = 'posts';
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
					$userid = $CurrentUser->UserId();
					
					$post_data = mysql_query("SELECT * FROM $postTable WHERE userid = '$userid' ORDER BY creation DESC");
					$projects = $CurrentUser->ProjectsWithLimit(4);
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
    <title>Home : QuillSword</title>
    
     <!-- JS INCLUDES -->
    <script src="js/jquery-1.10.0.min.js"></script>
    <script src="services/instantclick.min.js"></script>
    <script src="js/write.js"></script>
    <script src="js/projects.js"></script>
    <script src="js/read.js"></script>
    
    <!-- Web Fonts & stylesheets -->
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Berkshire+Swash' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>

<script type="text/javascript">
	
	var currentTab = "feed";
	function switchTab(tab_name)
	{
		if(currentTab != tab_name)
		{
			$('#home_'+currentTab+'_column').css("display", "none");
			$('#home_'+tab_name+'_column').css("display", "block");
			$('.home_tab_link').toggleClass("home_tab_active");
			currentTab = tab_name;
		}
	}
	
	function openProject(project_id)
	{
		window.location = "write.php?projectid=" + project_id;
	}
	
</script>

<body>
	<div id="site">
    	<div id="nav">
        	<div id="nav_inner">
            	<div id="nav_logo"><a href="home.php" data-instant>QuillSword</a></div>
                <div id="nav_home" class="nav_link nav_active"><a href="#home" data-instant>Home</a></div>
                <div id="nav_write" class="nav_link"><a href="projects.php" data-instant>Write</a></div>
                <div id="nav_read" class="nav_link"><a href="read.php" data-instant>Read</a></div>
                <div id="nav_profile" class="nav_link">
                	<div id="nav_profile_pic">
                    	<a href="#profile"><img id="profile_pic" src="img/default_profile.jpg"/></a>
                    </div>
                    <div id="nav_profile_text">
                		<a href="#profile"><?php echo $CurrentUser->FullName(); ?></a>
                        <div id="nav_logout">
                        	<a href="processes/logout.php">Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="nav_filler"></div>
        <div id="home_main">
        	<div id="home_main_inner">
            	<div id="home_tab_column">
                	<div id="home_tab_feed" class="home_tab_link home_tab_active"><a href="#feed" onclick="switchTab('feed')">Feed</a></div>
                    <div id="home_tab_discuss" class="home_tab_link"><a href="#discuss" onclick="switchTab('discuss')">Discuss</a></div>
                </div>
                <div id="home_feed_column" class="home_main_column">
                	<div id="home_feed_inner">
                    	<div id="home_feed_new_post_form">
                        	<form action="processes/newpost.php" method="post" enctype="multipart/form-data" name="home_new_post_form">
                            	<textarea name="new_post_text" class="new_post_form" placeholder="Content Here" cols="80" rows="7"></textarea>
                                <input name="submit_post" class="new_post_form new_post_submit" type="submit" value="Submit" />
                                <input name="new_post_tags" class="new_post_form new_post_tags" placeholder="Tags: Space Separated"/>
                                <input name="new_post_type" type="hidden" value="standard" />
                            </form>
                        </div>
                        <?php
						while($post = mysql_fetch_array($post_data))
						{
							echo '
							<div class="home_feed_post">
								<div class="home_feed_post_header">
									<div class="home_feed_post_profile_pic">
										<a href="#profile"><img class="post_profile_pic" src="img/default_profile.jpg"/></a>
									</div>
									<div class="home_feed_post_profile_text">
										<div class="home_feed_post_username">
											<a href="#profile" class="home_feed_post_header_link">'.$CurrentUser->FullName().'</a>
										</div>
										<div class="home_feed_post_date">
											'.$post['creation'].'
										</div>
									</div>
									<div class="home_feed_post_options">
										<a href="#dropdown" class="home_feed_post_header_link"><i class="fa fa-chevron-down notextselect"></i></a>
									</div>
								</div>
								<div class="home_feed_post_content">
									<div class="home_feed_post_label">
									</div>
									<div class="home_feed_post_content_main">
										'.$post['content'].'
									</div>
								</div>
								<div class="home_feed_post_footer">
									<a href="#comments" class="home_feed_post_footer_link">Comments</a>
									<a href="#rateup" class="home_feed_post_footer_link">Rate Up</a>
									<a href="#favorite" class="home_feed_post_footer_link">Favorite</a>
									<a href="#tag" class="home_feed_post_footer_link">Tag</a>
								</div>
							</div>
							';
						}
						?>
                    </div>
                </div>
                <div id="home_discuss_column" class="home_main_column">
                </div>
                <div id="home_control_panel_column">
                	<div id="home_control_panel_inner">
                    	<div id="home_control_panel_main_menu">
                        	<div><a href="#profile" class="home_control_panel_link">Profile</a></div>
                            <div><a href="#stats" class="home_control_panel_link">Stats</a></div>
                            <div><a href="#following" class="home_control_panel_link">Following</a></div>
                            <div><a href="#followers" class="home_control_panel_link">Followers</a></div>
                        </div>
                        <div id="home_recent_projects_menu">
                        	<div id="home_recent_projects_menu_header">Recent Projects</div>
                            <?php 
								foreach($projects as $project)
								{
									echo '<div><a href="#" onclick="openProject('.$project->ProjectId().')" class="home_recent_projects_link">'.$project->Title().'</a></div>';
								}
							?>
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