<?php
	include 'processes/connect.php';	
	include_once("services/PHPePub/EPub.php");
	
	$userTable = 'users';
	$postTable = 'posts';
	
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
					$loggedInUserFullName = $user['first_name']." ".$user['last_name'];
					$userid = $_SESSION['userid'];
					$post_data = mysql_query("SELECT * FROM $postTable WHERE userid = '$userid' ORDER BY creation DESC");
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
    <title>Read : QuillSword</title>
    
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
                <div id="nav_read" class="nav_link"><a href="#read" data-instant>Read</a></div>
                <div id="nav_profile" class="nav_link">
                	<div id="nav_profile_pic">
                    	<a href="profile.php"><img id="profile_pic" src="img/default_profile.jpg"/></a>
                    </div>
                    <div id="nav_profile_text">
                		<a href="profile.php"><?php echo $loggedInUserFullName; ?></a>
                        <div id="nav_logout">
                        	<a href="processes/logout.php">Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="nav_filler"></div>
        <div id="read_main">
        	<div id="read_main_inner">
                <div id="read_primary_column">
                	<div id="read_popular_panel" class="read_panel">
                    	<div class="read_panel_nav">
                        	<div class="read_panel_title">Popular Now</div>
                         	<div class="read_panel_subtitle">Based on Views</div>
                            <div class="read_panel_specificity_menu">
                            	<div><a href="#" class="read_panel_specificity_link">Followers</a></div>
                                <div><a href="#" class="read_panel_specificity_link">Following</a></div>
                                <div><a href="#" class="read_panel_specificity_link">Everyone</a></div>
                            </div>
                        </div>
                        <div class="read_panel_slider">
                        	<div class="read_panel_left_arrow read_panel_arrow"><i class="fa fa-chevron-left notextselect"></i></div>
                            <div class="read_panel_slider_covers">
                            	<div class="read_panel_slider_cover">
                                	<a href="#" class="read_slider_cover_image" style="background-image:url(userdata/covers/front/default.png)"></a>
                                    <a href="#" onclick="OpenSelectedPanel('2'); return false;" class="read_slider_cover_image_overlay">Fight Club</a>
                                </div>
                                <div class="read_panel_slider_cover">
                                	<a href="#" class="read_slider_cover_image" style="background-image:url(userdata/covers/front/default.png)"></a>
                                    <a href="#" onclick="OpenSelectedPanel('1'); return false;" class="read_slider_cover_image_overlay">Invisible Monsters</a>
                                </div>
                            </div>
                            <div class="read_panel_right_arrow read_panel_arrow"><i class="fa fa-chevron-right notextselect"></i></div>
                        </div>
                    </div>
                    <div id="read_recent_panel" class="read_panel">
                    	<div class="read_panel_nav">
                        	<div class="read_panel_title">Recently Shared</div>
                            <div class="read_panel_subtitle">Based on Date</div>
                            <div class="read_panel_specificity_menu">
                            	<div><a href="#" class="read_panel_specificity_link">Followers</a></div>
                                <div><a href="#" class="read_panel_specificity_link">Following</a></div>
                                <div><a href="#" class="read_panel_specificity_link">Everyone</a></div>
                            </div>
                        </div>
                        <div class="read_panel_slider">
                        	<div class="read_panel_left_arrow read_panel_arrow"><i class="fa fa-chevron-left notextselect inactive_read_panel_arrow"></i></div>
                            <div class="read_panel_slider_covers">
                            	<div class="read_panel_slider_cover">
                                	<a href="#" class="read_slider_cover_image" style="background-image:url(userdata/covers/front/default.png)"></a>
									<a href="#" onclick="OpenSelectedPanel('1'); return false;" class="read_slider_cover_image_overlay">Invisible Monsters</a>
                                </div>
                                <div class="read_panel_slider_cover">
                                	<a href="#" class="read_slider_cover_image" style="background-image:url(userdata/covers/front/default.png)"></a>
									<a href="#" onclick="OpenSelectedPanel('2'); return false;" class="read_slider_cover_image_overlay">Fight Club</a>
                                </div>
                            </div>
                            <div class="read_panel_right_arrow read_panel_arrow"><i class="fa fa-chevron-right notextselect"></i></div>
                        </div>
                    </div>
                    <div id="read_selected_panel" class="read_selected_panel">
                    	<div class="read_selected_cover_section">
                        	<div class="read_selected_section_header">
                            	<div class="read_panel_title">Selected Book</div>
                                <div class="read_panel_subtitle">Author Here</div>
                            </div>
                            <div class="read_selected_section_main">
                            	<div class="read_selected_front_cover">
                                	<div class="read_panel_slider_cover"><a href="#" class="read_slider_cover_image" style="background-image:url(userdata/covers/front/default.png)"></a></div>
                                </div>
                                <div class="read_selected_back_cover">
                                	<div class="read_panel_slider_cover"><a href="#" class="read_slider_cover_image" style="background-image:url(userdata/covers/front/default.png)"></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="read_selected_section">
                            <div class="read_selected_section_header">
                            	<div class="read_panel_title">Summary</div>
                            </div>
                            <div id="read_selected_section_summary" class="read_selected_section_main">
                            	A lot of really, super, cool stuff happens in this book.  Everyone who likes anything should read it for sure. Yes.  Read. It.  Description Description description.
                            </div>
                        </div>
                        <div class="read_selected_section">
                            <div class="read_selected_section_header">
                            	<div class="read_panel_title">Details</div>
                            </div>
                            <div class="read_selected_section_main">
                            	<table id="read_selected_details_table">
                                	<tr><td class="read_selected_details_table_title">Genre:</td><td class="read_selected_details_table_content">Dystopian</td></tr>
                                    <tr><td class="read_selected_details_table_title">Status:</td><td class="read_selected_details_table_content">Published</td></tr>
                                    <tr><td class="read_selected_details_table_title">Words:</td><td class="read_selected_details_table_content">18,530</td></tr>
                                    <tr><td class="read_selected_details_table_title">Scenes:</td><td class="read_selected_details_table_content">71</td></tr>
                                    <tr><td class="read_selected_details_table_title">Characters:</td><td class="read_selected_details_table_content">5</td></tr>
                                    <tr><td class="read_selected_details_table_title">Locations:</td><td class="read_selected_details_table_content">3</td></tr>
                                    <tr><td class="read_selected_details_table_title">Views:</td><td class="read_selected_details_table_content">1,230</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="read_selected_section">
                            <div class="read_selected_section_header">
                            	<div class="read_panel_title">Action</div>
                            </div>
                            <div class="read_selected_section_main">
                            	<div class="read_selected_action_button"><a href="#" class="read_selected_action_button_link">Read Now</a></div>
                                <div class="read_selected_action_button"><a href="#" class="read_selected_action_button_link">Comment</a></div>
                                <div class="read_selected_action_button"><a href="#" class="read_selected_action_button_link">Critique</a></div>
                                <div class="read_selected_action_button"><a href="#" class="read_selected_action_button_link">Buy Now</a></div>
                            </div>
                        </div>
                	 </div>
                </div>
                <div id="read_menu_column">
                	<div id="read_genre_menu">
                    	<div id="read_genre_menu_title">Genre</div>
                        <div><a href="#" class="read_genre_menu_link">Fantasy</a></div>
                        <div><a href="#" class="read_genre_menu_link">Science Fiction</a></div>
                        <div><a href="#" class="read_genre_menu_link">Procedural</a></div>
                        <div><a href="#" class="read_genre_menu_link">Thriller</a></div>
                        <div><a href="#" class="read_genre_menu_link">Romance</a></div>
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
    <script data-no-instant>InstantClick.init(true);</script>
</body>
</html>