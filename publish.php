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
    <title>Publish : QuillSword</title>
    
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
        <div id="home_main">
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