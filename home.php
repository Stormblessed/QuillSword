<?php
	include('processes/connect.php');	
	require_once('objects/User.php');
	require_once('objects/Project.php');
	require_once('objects/PostFeed.php');
	require_once('objects/GroupFeed.php');
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
					$userid = $CurrentUser->UserId();
					
					$Group = new Group(1);
					if(isset($_REQUEST['group_id']))
						$Group = new Group($_REQUEST['group_id']);
					
					$PostFeed = new PostFeed();
					$PostFeed->LoadPosts($userid, $Group->Name());
					$Posts = $PostFeed->Posts();
					
					$SavedGroups = $CurrentUser->SavedGroups();
					$GroupFeed = new GroupFeed();
					$GroupFeed->LoadPopularGroupsWithLimit(4);
					$PopularGroups = $GroupFeed->Groups();
					
					$Projects = $CurrentUser->ProjectsWithLimit(4);
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
                <div id="nav_home" class="nav_link nav_active"><a href="#home" data-instant>Home</a></div>
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
                	<div id="home_group_menu_set">
                    	<div id="home_default_groups" class="home_group_set">
                        	<div id="default_groups_header" class="group_menu_header"> Default Groups </div>
                            <div id="default_groups_set" class="group_menu_set">
                            	<div class="default_group group_menu_item">
                                	<a class="group_menu_link" href="home.php">
                                    	<img class="group_menu_link_img" src="img/rocket.png"/><div class="group_menu_link_text">Following</div><div class="group_new_items_count">
                                        	<?php echo count($CurrentUser->FollowingUsers()); ?>
                                        </div>
                                    </a>
                                </div>
                                <div class="default_group group_menu_item">
                                	<a class="group_menu_link" href="home.php?group_id=2">
                                    	<img class="group_menu_link_img" src="img/rocket.png"/><div class="group_menu_link_text">Followers</div><div class="group_new_items_count">
                                        	<?php echo count($CurrentUser->FollowedUsers()); ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    	<div id="home_followed_groups" class="home_group_set">
                        	<div id="followed_groups_header" class="group_menu_header"> Saved Groups </div>
                            <div id="followed_groups_set" class="group_menu_set">
                            <?php
								foreach($SavedGroups as $saved_group)
								{
									echo '
										<div class="followed_group group_menu_item">
											<a class="group_menu_link" href="home.php?group_id='.$saved_group->GroupId().'">
												<img class="group_menu_link_img" src="img/rocket.png"/>
												<div class="group_menu_link_text">'.$saved_group->Name().'</div>
												<div class="group_new_items_count">'.$saved_group->SavedByCount().'</div>
											</a>
										</div>
										 ';
								}
							?>
                            </div>
                        </div>
                        <div id="home_popular_groups" class="home_group_set">
                        	<div id="popular_groups_header" class="group_menu_header"> Popular Groups</div>
                            <?php
								foreach($PopularGroups as $popular_group)
								{
									echo '
										<div class="followed_group group_menu_item">
											<a class="group_menu_link" href="home.php?group_id='.$popular_group->GroupId().'">
												<img class="group_menu_link_img" src="img/rocket.png"/>
												<div class="group_menu_link_text">'.$popular_group->Name().'</div>
												<div class="group_new_items_count">'.$popular_group->SavedByCount().'</div>
											</a>
										</div>
										 ';
								}
							?>
                        </div>
                        <div id="home_options_group" class="home_group_set">
                        	<div id="options_groups_header" class="group_menu_header">Option Groups</div>
                            <div id="options_groups_set" class="group_menu_set">
                            	<div class="options_group group_menu_item">
                                    <a class="group_menu_link" href="groups.php" data-instant>
                                        <img class="group_menu_link_img" src="img/orange_plus.png"/>
                                        <div class="group_menu_link_text">Add Groups Now</div>
                                        <div class="group_new_items_count"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="home_feed_column">
                	<div id="home_feed_top_section" class="home_feed_section">
                    	<div id="home_feed_control_panel" class="home_feed_top_panel">
                        	<div class="home_feed_control_panel_header"><?php echo $Group->Name(); ?></div>
                            <div class="home_feed_control_panel_main">
                            	<?php echo $Group->Description(); ?>
                            </div>
                            <div class="home_feed_control_panel_options">
                            	<?php echo $Group->WriteOptions($userid); ?>
                            </div>
                        </div>
                        <div id="home_feed_post_panel" class="home_feed_top_panel">
                        	<div class="home_feed_new_post">
                            	<div class="home_feed_new_post_title">Share your thoughts</div>
                        		<form action="processes/newpost.php" method="post" enctype="multipart/form-data" name="new_post">
                                	<textarea class="new_post_textarea" placeholder="What's new?" name="new_post_textarea" cols="" rows=""></textarea>
                                    <div class="home_feed_new_post_options">
                                    	<div class="home_feed_new_post_option_links">
                                        </div>
                                        <input class="new_post_submit" name="new_post_submit" type="submit" value="Post" />
                                        <input type="hidden" class="new_post_hidden" name="new_post_location" value="Followers"/>
                                        <div class="home_feed_new_post_buttons">
                                        	<div class="new_post_location_select">
                                            	<a href="#" onclick="NewLocationDropdown(); return false;" class="new_post_location_header">Followers</a>
                                                <div class="new_post_location_options">
                                                	<a href="#" onclick="SwitchLocation('Followers'); return false;" class="new_post_location_option">Followers</a>
                                                    <?php
														foreach($SavedGroups as $saved_group)
														{
															echo '
																<a href="#" onclick="SwitchLocation(\''.$saved_group->name().'\'); return false;" class="new_post_location_option">
																	'.$saved_group->name().'
																</a>
																 ';
														}
													?>
                                                </div>
                                            </div>
                                        </div>
                            		</div>
                            	</form>
                            </div>
                        </div>
                    </div>
                    <div id="home_feed_content_section" class="home_feed_section">
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
                        	<div><a href="profile.php" class="home_control_panel_link" data-instant>Profile</a></div>
                            <div><a href="#stats" class="home_control_panel_link">Stats</a></div>
                            <div><a href="users.php" class="home_control_panel_link">Following</a></div>
                            <div><a href="users.php" class="home_control_panel_link">Followers</a></div>
                        </div>
                        <div id="home_recent_projects_menu">
                        	<div id="home_recent_projects_menu_header">Recent Projects</div>
                            <?php 
								foreach($Projects as $project)
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