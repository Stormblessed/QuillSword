<?php
	include('processes/connect.php');	
	require_once('objects/UserFeed.php');
	require_once('objects/User.php');
	
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
					$Following = $CurrentUser->FollowingUsers();
					$Followers = $CurrentUser->FollowedUsers();	
					
					if(isset($_POST['search_users_name']))
					{
						$UserFeed = new UserFeed();
						$UserFeed->LoadUsersWithSimilarName($_POST['search_users_name']);
						$SearchUsers = $UserFeed->Users();
					}
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
    <title>Users : QuillSword</title>
    
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
            	<div id="users_top_row">
                	<form action="users.php" method="post" enctype="application/x-www-form-urlencoded" name="search_users">
                    	<input id="search_users_name" class="search_users_field" name="search_users_name" type="text" placeholder="Type here to search for a user"/>
                    </form>
                </div>
                <div id="users_search_display">
                	<?php
					if(isset($_POST['search_users_name']))
					{
						foreach($SearchUsers as $searched_user)
						{
							$showOnClickFollow = 'onclick="ToggleFollow('.$searched_user->UserId().',\'\');"';
							if($searched_user->UserId() == $CurrentUser->UserId())
							{
								$follow_button_text = "You";
								$showOnClickFollow = " ";
							}
							else if($CurrentUser->IsFollowingUser($searched_user->UserId()))
								$follow_button_text = "Unfollow";
							else
								$follow_button_text = "Follow";
									
							echo '<div class="users_search_item">
									<a href="profile.php?userid='.$searched_user->UserId().'" class="users_search_profile_image users_search_link">
										<img class="users_search_profile_img" src="img/default_profile.jpg"/>
									</a>
									<a href="profile.php?userid='.$searched_user->UserId().'" class="users_search_name users_search_link users_search_link_text">'.$searched_user->FullName().'</a>
									<a href="#" '.$showOnClickFollow.' class="users_search_follow users_search_link users_search_link_text follow_user_'.$searched_user->UserId().'">
										'.$follow_button_text.'
									</a>
								  </div>';
						}
					}
					?>
                </div>
                <div id="users_follow_display">
                	<div id="users_following_section" class="users_follow_column">
                    	<div id="following_header" class="users_column_header users_follow_row">
                        	Following
                            <div id="following_count" class="follow_count"><?php echo count($Following); ?></div>
                        </div>
                        <?php
							foreach($Following as $followed)
							{
								echo '
									<div class="users_follow_row">
										<a href="#" class="follow_row_icon follow_row_item"><img class="follow_row_icon_img" src="img/default_profile.jpg"/></a>
										<a href="profile.php?userid='.$followed->UserId().'" class="follow_row_name follow_row_item">'.$followed->FullName().'</a>
										<a href="#" onclick="ToggleFollow('.$followed->UserId().',\'\');" class="follow_row_button follow_row_item follow_user_'.$followed->UserId().'">
											Unfollow
										</a>
									</div>
									 ';
							}
						?>
                        
                    </div>
                    <div id="users_followers_section" class="users_follow_column">
                    	<div id="followers_header" class="users_column_header users_follow_row">
                        	Followers
                            <div id="followers_count" class="follow_count"><?php echo count($Followers); ?></div>
                        </div>
                        <?php
							foreach($Followers as $follower)
							{
								if($CurrentUser->IsFollowingUser($follower->UserId()))
									$follow_button_text = "Unfollow";
								else
									$follow_button_text = "Follow";
								echo '
									<div class="users_follow_row">
										<a href="#" class="follow_row_icon follow_row_item"><img class="follow_row_icon_img" src="img/default_profile.jpg"/></a>
										<a href="profile.php?userid='.$follower->UserId().'" class="follow_row_name follow_row_item">'.$follower->FullName().'</a>
										<a href="#" onclick="ToggleFollow('.$follower->UserId().',\'\');" class="follow_row_button follow_row_item follow_user_'.$follower->UserId().'">
											'.$follow_button_text.'
										</a>
									</div>
									 ';
							}
						?>
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