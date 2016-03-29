<?php
	include('processes/connect.php');	
	require_once('objects/User.php');
	require_once('objects/Group.php');
	require_once('objects/GroupFeed.php');
	
	$userTable = 'users';
	
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
					$CurrentUser = new User($_SESSION['userid']);
					$userid = $CurrentUser->UserId();
										
					$SavedGroups = $CurrentUser->SavedGroups();
					$GroupFeed = new GroupFeed();
					$GroupFeed->LoadGroups($userid);
					$Groups = $GroupFeed->Groups();
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
    <title>Groups : QuillSword</title>
    
     <!-- JS INCLUDES -->
    <script src="js/jquery-1.10.0.min.js"></script>
    <script src="services/instantclick.min.js"></script>
    <script src="services/masonry.pkgd.min.js"></script>
    <script src="js/write.js"></script>
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
                <div id="nav_home" class="nav_link nav_active"><a href="home.php" data-instant>Home</a></div>
                <div id="nav_write" class="nav_link"><a href="projects.php" data-instant>Write</a></div>
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
        <div id="home_main">
            <div id="groups_main_inner">
                <div id="groups_top_menu">
                    <a href="#" id="create_group_button" class="groups_top_menu_pane" onclick="CreateGroupDropDown(); return false;">Create Group</a>
                    <div id="search_groups" class="groups_top_menu_pane">
                    </div>
                </div>
                <div id="groups_display">
                	<form id="create_group_form" action="processes/creategroup.php" method="get" enctype="application/x-www-form-urlencoded" name="create_group_form">
                    	<div id="home_feed_control_panel" class="home_feed_top_panel group_box">
                            <div class="home_feed_control_panel_header">
                            	<input name="create_group_title" id="create_group_title" class="create_group_field" type="text" placeholder="Group Title"/>
                            </div>
                            <div class="home_feed_control_panel_main">
                                <textarea name="create_group_description" id="create_group_description" class="create_group_field" placeholder="Group Description"></textarea>
                            </div>
                            <div class="home_feed_control_panel_options">
                            	<input name="create_group_submit" id="create_group_submit" type="submit" value="Create" />
                                <a href="#cancel" class="home_feed_control_panel_option" title="Cancel" onclick="CreateGroupDropDown(); return false;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                    	</div>
                    </form>
                	<?php
					foreach($Groups as $group)
					{
						echo '
							<div id="home_feed_control_panel" class="home_feed_top_panel group_box">
								<div class="home_feed_control_panel_header">'.$group->Name().'</div>
								<div class="home_feed_control_panel_main">
									'.$group->Description().'
								</div>
								<div class="home_feed_control_panel_options">
									'.$group->WriteOptions($userid).'
								</div>
							</div>
							 ';
					}
					?>
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