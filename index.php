<?php
	include 'processes/connect.php';	
	$userTable = 'users';
		
	if(isset($_SESSION['active']))
	{
		$loggedInActivity = $_SESSION['active'];
		if($loggedInActivity == true)
		{
			header("Location: home.php");
		}
	}
	
	if(isset($_GET['msg']))
	{
		$registration_response = '<div id="registration_response_text">'.$_GET['msg'].'</div>';
	}
	else
	{
		$registration_response = "";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>QuillSword</title>
    
    <!-- JS INCLUDES -->
    <script src="js/jquery-1.10.0.min.js"></script>
    <script src="services/instantclick.min.js"></script>
    <script src="services/nod.min.js"></script>
    <script src="js/index.js"></script>
    
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
            	<div id="nav_logo"><a href="index.php" data-instant>QuillSword</a></div>
                <div id="nav_home" class="nav_link"><a href="home.php" data-instant>Home</a></div>
                <div id="nav_write" class="nav_link"><a href="#write" data-instant>Write</a></div>
                <div id="nav_read" class="nav_link"><a href="#read" data-instant>Read</a></div>
                <div id="nav_login" class="nav_link"><a href="#login" onclick="login()">Sign In</a></div>
            </div>
        </div>
        <div id="nav_filler"></div>
        <div id="register_slide">
        	<div id="register_slide_inner">
            	<div id="register_slide_logo">
                	<img src="img/logo_beta.png" width="400px" height="408px"/>
                </div> 
                <div id="register_slide_form">
                	<form id="register_form" action="processes/register.php" method="post" name="register_form" enctype="multipart/form-data">
                    	<input id="first_name" name="first_name" class="register_text_input register_form" type="text" size="48" maxlength="64" placeholder="First Name"/>
                        <input id="last_name" name="last_name" class="register_text_input register_form" type="text" size="48" maxlength="64" placeholder="Last Name"/>
                        <input id="email" name="email" class="register_text_input register_form" type="text" size="48" maxlength="256" placeholder="Email"/>
                        <input id="password" name="password" class="register_text_input register_form" type="password" size="48" maxlength="256" placeholder="Password"/>
                        <input id="password_repeat" name="password_repeat" class="register_text_input register_form" type="password" size="48" maxlength="256" placeholder="Repeat Password"/>
                        <input id="register_submit" name="register_submit_btn" class="register_button register_form" type="submit" value="Submit"/>
                     </form>
                </div>
                <div id="nav_login_form">
                    <form action="processes/login.php" method="post" name="login_form" enctype="multipart/form-data">
                        <input name="email" class="register_text_input register_form" type="text" size="48" maxlength="256" placeholder="Email"/>
                        <input name="password" class="register_text_input register_form" type="password" size="48" maxlength="256" placeholder="Password"/>
                        <input name="login_submit" class="login_button register_form" type="submit" value="Submit"/>
                    </form>
                   	<div id="register_slide_body_button" class="open_sans goto_register">
                    	<a href="#register" onclick="register()">Don't have an account?  Sign up for one for free</a>
                    </div>
                </div>
                <div id="register_slide_body">
                	<div id="register_slide_body_text">
                    	<?php echo $registration_response; ?>
                    	QuillSword strives to make the writing process more enjoyable as well as more manageable by organizing your content, 
                        integrating the community, 
                        and prov&shy;iding a rewards system to spur you onwards.
                    </div>
                    <div id="register_slide_body_button">
                    	<a href="#register" onclick="register()">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="info_slide">
        	<div id="info_slide_inner">
            	<div id="info_write" class="info_block">
                	<div class="info_head">
                    	<div class="info_head_icon"><i class="fa fa-pencil-square-o notextselect"></i></div>
                        <div class="info_head_title">
                        	Write
                        </div>
                    </div>
                    <div class="info_body">
                    	QuillSword provides a suite of tools to help you manage all the elements of your writing, as well 
                        as provide helpful goals. From characters and 
                        locations to scenes QuillSword will help you keep track of it all and transform all those disparate elements into a novel.
                    </div>
                </div>
                <div id="info_collaborate" class="info_block">
                	<div class="info_head">
                    	<div class="info_head_icon"><i class="fa fa-comments notextselect"></i></div>
                        <div class="info_head_title">
                        	Collaborate
                        </div>
                    </div>
                    <div class="info_body">
                   		Help critique and suggest edits for your friends' work, or release select sections of your work, 
                        allowing the community to help you grow as a writer. 
                        Become highly regarded as an editor, and you can even charge for your services (if you want to).
                    </div>
                </div>
                <div id="info_publish" class="info_block">
                	<div class="info_head">
                    	<div class="info_head_icon"><i class="fa fa-print notextselect"></i></div>
                        <div class="info_head_title">
                        	Publish
                        </div>
                    </div>
                    <div class="info_body">
                    	Once you've got your book all written out and perfected, QuillSword provides you with the tools 
                        you need to get your book published on all the popular ebook services.
                        ie. Amazon Kindle and B&N Nook
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