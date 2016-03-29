<?php
	require('processes/connect.php');
	require('objects/Project.php');
	require('objects/User.php');
	require_once('objects/Crypt.php');
	
	$userTable = 'users';
	
	$_SESSION['project_id'] = $_GET['projectid'];
	$_SESSION['scene_id'] = 0;
	
	$project = Project::WithExternalId($_SESSION['project_id']);
		
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
    <title>Write : QuillSword</title>
    
     <!-- JS INCLUDES -->
    <script src="js/jquery-1.10.0.min.js"></script>
    <script src="services/ckeditor/ckeditor.js"></script>
    <script src="services/jquery-waiting/dist/jquery.waiting.js"></script>
    <script src="services/instantclick.min.js"></script>
    <script src="services/masonry.pkgd.min.js"></script>
    <script src="js/write.js"></script>
    <script src="js/projects.js"></script>
    <script src="js/read.js"></script>
    <script src="js/home.js"></script>
    <script src="js/groups.js"></script>
    <script src="js/profile.js"></script>
    <script src="services/magnific/magnific.min.js"></script>
        
    <!-- Web Fonts & stylesheets -->
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Berkshire+Swash' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="services/jquery-waiting/dist/waiting.css">
    <link rel="stylesheet" href="services/magnific/magnific-popup.css" />
</head>

<script type="text/javascript">
	var current_content_id = <?php echo $_SESSION['scene_id'];?>;
	loadEditorContent(current_content_id, "scene");
	<?php 
	if($project->IsFirstLoad())
	{
		echo '
			$(document).ready(function() {	
				$("#first_time_popup").magnificPopup({
				  items: {
					src: "#first_time_popup",
					type: "inline"
				  }
				}).magnificPopup("open");
				
				$(".mfp-close").click(function(){
					$.magnificPopup.close();
				});
			});
			 ';
	}
	?>
</script>

<body>
	<div id="first_time_popup" class="white-popup mfp-hide">
    	<div id="first_time_header">
        	Welcome
        </div>
        <div id="first_time_content">
        	This is the editor.  <br/>
            Before you get started, here's a quick overview:<br/><br/>
            In the middle of the screen lies the Editor Document.  <br/>
            It changes forms to match the type of content you are editing.  It supports rich-text editing, which includes images. <br/><br/>
            On the left, there is the Project Menu.  It features three tabs: scenes, characters, and locations.  Expanding them allows you to manage and open the content you have created. <br/><br/>
            The right contains the Project Toolsets.  The toolsets contain menus such as Revisions and Sharing. <br/><br/>
            Any changes you make to your project are saved and encrypted automatically in the background. <br/><br/>
            The goal is to help get your story out of your head and onto paper in a smooth, and organized fashion.<br/><br/>
        </div>
        <div id="first_time_footer">
        	Thanks,<br/>
            QuillSword
        </div>
    </div>
	<div id="site">
        <div id="editor_toolbar">
        	<div id="editor_toolbar_inner">
            	<div id="editor_toolbar_top_menu">
                	<div id="editor_toolbar_projects_link" class="editor_toolbar_link"><a href="projects.php" class="light_toolbar_link" data-instant> < Projects</a></div>
                    <div id="editor_toolbar_project_title" class="editor_toolbar_link"><a href="#projects" class="heavy_toolbar_link"> <?php echo $project->Title(); ?></a></div>
                    <div id="editor_toolbar_project_save_state" class="editor_toolbar_link"><a href="#save" class="light_toolbar_link">Saved: <?php echo $project->LastEdited(); ?></a></div>
                    <div id="editor_toolbar_profile_link" class="editor_toolbar_link"><a href="profile.php" class="heavy_toolbar_link" data-instant><?php echo $CurrentUser->FullName(); ?></a></div>
                    <div id="editor_toolbar_profile_pic" class="editor_toolbar_link">
                    	<a href="profile.php"><img id="editor_profile_pic" src="img/default_profile.jpg"/></a>
                    </div>
                </div>
                <div id="editor_toolbar_ck"></div>
            </div>
        </div>
        <div id="editor_toolbar_filler"></div>
		<div id="editor">
        	<div id="editor_inner">
            	<div id="editor_left_menu">
                	<div id='cssmenu'>
                        <ul>
                           <li><a href='#nogo'><span><?php echo $project->Title(); ?></span></a></li>
                           <li class='has-sub'><a id="scenes_menu_top" href='#'><span>Scenes</span></a>
                              <ul id="cssmenu_scenes">
                              	  <?php
								  	  $sceneResultSet = $project->fetchSceneList();
									  $SceneMappings = $project->ProjectMappings->SceneMappings();
									  while($scene = mysql_fetch_assoc($sceneResultSet))
									  {
										  echo '
										  <li>
										  	<a href="#" onclick="switchEditor(\''.$SceneMappings->Externalize($scene['id']).'\',\'scene\')">
										  		<span id="editor_cssmenu_scene_'.$SceneMappings->Externalize($scene['id']).'">'
													.\Crypt::Decrypt($scene['title'], $_SESSION['crypt_pass']).
												'</span>
										  	</a>
										  </li>';
									  }
							      ?>
                                  <div id="next_scene_spot"></div>
                                  <li class="last"><a href='#' onclick="newContent('scene')"><span>New Scene</span></a></li>
                              </ul>
                           </li>
                           <li class='has-sub'><a id="characters_menu_top" href='#'><span>Characters</span></a>
                              <ul id="cssmenu_characters">
                              	  <?php
								  	  $characterResultSet = $project->fetchCharacterList();
									  $CharacterMappings = $project->ProjectMappings->CharacterMappings();
									  while($character = mysql_fetch_assoc($characterResultSet))
									  {
									  	  echo '
										  <li>
											  <a href="#" onclick="switchEditor(\''.$CharacterMappings->Externalize($character['id']).'\',\'character\')">
											  	<span id="editor_cssmenu_character_'.$CharacterMappings->Externalize($character['id']).'">'
													.\Crypt::Decrypt($character['full_name'], $_SESSION['crypt_pass']).'
												</span>
											  </a>
										  </li>';
									  }
								  ?>
                                  <div id="next_character_spot"></div>
                                  <li class='last'><a href='#' onclick="newContent('character')"><span>New Character</span></a></li>
                              </ul>
                           </li>
                           <li class='has-sub last'><a id="locations_menu_top" href='#'><span>Locations</span></a>
                              <ul id="cssmenu_locations">
                                  <?php
								  	  $locationResultSet = $project->fetchLocationList();
									  $LocationMappings = $project->ProjectMappings->LocationMappings();
									  while($location =  mysql_fetch_assoc($locationResultSet))
									  {										  
									  	  echo '
										  <li>
										  	<a href="#" onclick="switchEditor(\''.$LocationMappings->Externalize($location['id']).'\',\'location\')">
												<span id="editor_cssmenu_location_'.$LocationMappings->Externalize($location['id']).'">'
													.\Crypt::Decrypt($location['title'], $_SESSION['crypt_pass']).'
												</span>
											</a>
										  </li>';
									  }
								  ?>
                                  <div id="next_location_spot"></div>
                                  <li class='last'><a href='#' onclick="newContent('location')"><span>New Location</span></a></li>
                              </ul>
                           </li>
                        </ul>
                    </div>
                </div>
                <div id="editor_document" name="scene">
                	<div id="scene_editor">
                    	<div id="scene_title">
                        	<div contenteditable="true" id="scene_title_textarea" class="ckeditor_textarea"></div>
                        </div>
                        <div id="scene_content">
                        	<div contenteditable="true" id="scene_content_textarea" class="ckeditor_textarea"></div>
                        </div>
                    </div>
                    <div id="character_editor">
                    	<div id="character_shortname">
                        	<div class="edit_label">Short Name</div>
                    		<div contenteditable="true" id="character_shortname_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	Primary name, first name, common name.  Ex: John, Eris, Major. 
                        	</div>
                        </div>
                        
                        <div id="character_fullname">
                        	<div class="edit_label">Full Name</div>
                        	<div contenteditable="true" id="character_fullname_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	The full name of the character.  Ex: John Smith, Eris Britta.
                            </div>
                        </div>
                        <div id="character_altnames">
                        	<div class="edit_label">Alternate Names</div>
                        	<div contenteditable="true" id="character_altnames_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	Less common names of the characters.  Old nicknames.
                            </div>
                        </div>
                        <div id="character_description">
                        	<div class="edit_label">Description</div>
                        	<div contenteditable="true" id="character_description_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	Who the character is emotionally and physically.
                            </div>
                        </div>
                        <div id="character_significance">
                        	<div class="edit_label">Significance</div>
                        	<div contenteditable="true" id="character_significance_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	How the character is significant to the book in terms of plot or theme.
                            </div>
                        </div>
                    </div>
                    <div id="location_editor">
                    	<div id="location_title">
                        	<div class="edit_label">Title</div>
                    		<div contenteditable="true" id="location_title_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	Primary name of the location.
                            </div>
                        </div>
                        <div id="location_alt_titles">
                        	<div class="edit_label">Alternate Titles</div>
                        	<div contenteditable="true" id="location_alt_titles_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	Other names the location is known by in the book's context.
                            </div>
                        </div>
                        <div id="location_description">
                        	<div class="edit_label">Description</div>
                        	<div contenteditable="true" id="location_description_textarea" class="ckeditor_textarea"></div>
                            <div class="edit_description">
                            	The structure of the location. Interesting facets of its design, etc...
                            </div>
                        </div>
                    </div>        
                    <script src="js/editors.js"></script>
                </div>
                <div id="editor_right_menu">
                	<div id="editor_revisions_menu">
                    	<div id="editor_revisions_button">
                        	<a id="editor_revisions_button_link" href="#rev" onclick="ToggleRevisionsDropDown()">Revisions</a>
                        </div>
                        <div id="editor_revisions_display">
                        	<div class="editor_revision_tab">
                                <div class="editor_revision_date">December 23, 2014</div>
                                <div class="editor_revision_links">
                                	<div class="editor_revision_link"><a href="#preview">Preview</a></div>
                                	<div class="editor_revision_link"><a href="#revert">Revert</a></div>
                                </div>
                            </div>
                            <div class="editor_revision_tab">
                            	<div class="editor_revision_date">November 18, 2014</div>
                                <div class="editor_revision_links">
                                	<div class="editor_revision_link"><a href="#preview">Preview</a></div>
                                	<div class="editor_revision_link"><a href="#revert">Revert</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br style="clear:both"/>
            </div>
        </div>
        <div id="editor_bottom"></div>
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