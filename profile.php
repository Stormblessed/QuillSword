<?php
	include('processes/connect.php');	
	require_once('objects/User.php');
	require_once('objects/Project.php');
	require_once('objects/PostFeed.php');
	require_once('objects/Group.php');
	
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
					
					if(isset($_GET['userid']))
						$ViewedUser = new User($_GET['userid']);
					else
						$ViewedUser = $CurrentUser;			
										
					$PostFeed = new PostFeed();
					$PostFeed->LoadUsersPosts($ViewedUser->UserId());
					$Posts = $PostFeed->Posts();
					$SavedGroups = $CurrentUser->SavedGroups();
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
    <title><?php echo $ViewedUser->FullName(); ?> : QuillSword</title>
    
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
                    	<a href="profile.php" data-instant><img id="profile_pic" src="img/default_profile.jpg"/></a>
                    </div>
                    <div id="nav_profile_text">
                		<a href="profile.php" data-instant><?php echo $CurrentUser->FullName(); ?></a>
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
            	<div id="home_left_menu_column">
                	<div id="profile_left_menu">
                        <div id="profile_user_icon" class="profile_left_menu_item">
                            <img id="profile_user_img" src="img/default_profile.jpg"  />
                        </div>        
                        <div class="profile_left_menu_item">
                        	<?php echo $ViewedUser->FullName(); ?>
                        </div>  
                    </div>
                	<div id="home_group_menu_set">
                    	<div id="profile_public_projects" class="home_group_set">
                        	<div id="default_groups_header" class="group_menu_header"> Public Projects </div>
                            <div id="default_groups_set" class="group_menu_set">
                            	<div class="default_group group_menu_item">
                                	<a class="group_menu_link" href="home.php">
                                    	<div class="group_menu_link_text">The Shadows Speak</div>
                                    </a>
                                </div>
                                <div class="default_group group_menu_item">
                                	<a class="group_menu_link" href="home.php?group_id=2">
                                    	<div class="group_menu_link_text">Look Inside</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <div id="home_feed_column">
                	<div id="profile_content_section">
                    	<div id="profile_description_section" class="profile_section">
                        	<div class="profile_section_header">Description</div>
                            <div id="profile_description_text" class="profile_section_text">
                                <?php echo $ViewedUser->Description(); ?>
                            </div>
                        </div>
                        <div id="profile_genre_section" class="profile_section">
                        	<div class="profile_section_header">Favorite Genres</div>
                            <div id="profile_genres_text" class="profile_section_text">
								<?php echo $ViewedUser->Genres(); ?>
                            </div>
                        </div>
                        <div id="profile_books_section" class="profile_section">
                        	<div class="profile_section_header">Favorite Books</div>
                            <div id="profile_books_text" class="profile_section_text">
								<?php echo $ViewedUser->Books(); ?>
                            </div>
                        </div>
                        <div id="profile_authors_section" class="profile_section">
                        	<div class="profile_section_header">Favorite Authors</div>
                            <div id="profile_authors_text" class="profile_section_text">
								<?php echo $ViewedUser->Authors(); ?>
                            </div>
                        </div>

                    </div>
                    <div id="home_feed_content_section" class="home_feed_section profile_feed_section">
                    <?php
						foreach($Posts as $post)
						{
							echo '
							<div class="home_feed_post_block">
								<div class="home_feed_post_block_header">
									<div class="home_feed_post_block_icon">
										<img class="post_block_icon_img" src="img/default_profile.jpg" />
									</div>
									<a href="profile.php?userid='.$post->UserId().'" class="home_feed_post_block_name" data-instant>'.$post->UserFullName().'</a>
									<div class="home_feed_post_block_info">
										<div class="home_feed_post_block_date">'.$post->Creation().'</div>
										<div class="home_feed_post_block_location">
											in <a class="location_link" href="home.php?group_id='.$post->GroupId().'">'.$post->GroupName().'</a>
										</div>
									</div>
								</div>
								<div class="home_feed_post_block_content">
									'.$post->Content().'
								</div>
								<div class="home_feed_post_block_menu">
									<a href="#item" class="post_block_menu_item">
										<div class="post_block_menu_star post_block_menu_icon"><i class="fa fa-star"></i></div>
										<div class="post_block_menu_count">17</div>
									</a>
									<a href="#item" class="post_block_menu_item">
										<div class="post_block_menu_comment post_block_menu_icon"><i class="fa fa-comments"></i></div>
										<div class="post_block_menu_count">4</div>
									</a>
									<a href="#item" class="post_block_menu_item">
										<div class="post_block_menu_share post_block_menu_icon"><i class="fa fa-share-square"></i></div>
										<div class="post_block_menu_count">343</div>
									</a>
								</div>
							</div>';
						}
					?>
                    </div>
                    <a href="#" id="home_feed_load_content_section" onclick="return false;">
                    	If there is more content to load, it will appear shortly.
                    </a>
                </div>
                <div id="home_control_panel_column">
                	<div id="home_control_panel_inner">
                    	<div id="home_control_panel_main_menu">
                        	<?php
								if($ViewedUser->UserId() != $CurrentUser->UserId())
								{
									if($CurrentUser->IsFollowingUser($ViewedUser->UserId()))
										$follow_option_text = "Unfollow ".$ViewedUser->FirstName();
									else
										$follow_option_text = "Follow ".$ViewedUser->FirstName();
									echo '<div>
											<a id="toggle_follow_link" href="#" onclick="ToggleFollow('.$ViewedUser->UserId().', \''.$ViewedUser->FirstName().'\');" class="home_control_panel_link">
												'.$follow_option_text.'
											</a>
										  </div>';
								}
								else
								{
									echo '
										<div><a href="#posts" id="toggle_edit_profile" class="home_control_panel_link" onclick="ToggleEditing(); return false;">Edit Profile</a></div>
										<div><a href="#posts" id="save_edits_profile" class="home_control_panel_link" onclick="SaveEdits(); return false;">Save Edits</a></div>
										 ';
								}
							?>
                            <div><a href="#posts" id="profile_toggle_posts" class="home_control_panel_link" onclick="TogglePosts(); return false;">Hide Posts</a></div>
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