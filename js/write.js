// JavaScript Document

var IsTest = false;
	
var first_editor_load = true;

function loadEditorContent(content_id, content_type)
{
	switch(content_type)
	{
		case "scene":
			loadSceneContent(content_id);
			$('#scene_editor').css('display', 'block');
			$('#location_editor').css('display', 'none');
			$('#character_editor').css('display', 'none');
			break;
		case "character":
			loadCharacterContent(content_id);
			$('#scene_editor').css('display', 'none');
			$('#location_editor').css('display', 'none');
			$('#character_editor').css('display', 'block');
			break;
		case "location":
			loadLocationContent(content_id);
			$('#scene_editor').css('display', 'none');
			$('#location_editor').css('display', 'block');
			$('#character_editor').css('display', 'none');
			break;
		default:
			break;
	}
	
	$(document).ready(function(e) {
		SwitchEditorInstantiations(content_type);
	});
}

function loadSceneContent(scene_id)
{
	request = $.ajax({
		url: "ajax/load_scene_editor_content.php",
		type: "POST",
		dataType:"json",
		data: {"scene_id" : scene_id}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		$('#scene_content_textarea').html(response['content']);
		$('#scene_title_textarea').html(response['title']);
		if(first_editor_load)
			first_editor_load = false;
		else
			$('#editor').waiting('done');
		current_content_id = scene_id;
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function loadCharacterContent(character_id)
{
	request = $.ajax({
		url: "ajax/load_character_editor_content.php",
		type: "POST",
		dataType:"json",
		data: {"character_id" : character_id}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		$('#character_shortname_textarea').html(response['short_name']);
		$('#character_fullname_textarea').html(response['full_name']);
		$('#character_altnames_textarea').html(response['alt_names']);
		$('#character_description_textarea').html(response['description']);
		$('#character_significance_textarea').html(response['significance']);
		if(first_editor_load)
			first_editor_load = false;
		else
			$('#editor').waiting('done');
		current_content_id = character_id;
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function loadLocationContent(location_id)
{	
	request = $.ajax({
		url: "ajax/load_location_editor_content.php",
		type: "POST",
		dataType:"json",
		data: {"location_id" : location_id}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		$('#location_title_textarea').html(response['title']);
		$('#location_alt_titles_textarea').html(response['alt_titles']);
		$('#location_description_textarea').html(response['description']);
		if(first_editor_load)
			first_editor_load = false;
		else
			$('#editor').waiting('done');
		current_content_id = location_id;
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function newContent(content_type)
{
	$('#editor').waiting();
	saveEditorContent();
	switch(content_type)
	{
		case "scene":
			newScene();
			break;
		case "character":
			newCharacter();
			break;
		case "location":
			newLocation();
			break;
		default:
			break;
	}
}

function newScene()
{
	request = $.ajax({
		url: "ajax/new_scene_editor_content.php",
		type: "POST",
		dataType:"json"
	});
	
	request.done(function (response, textStatus, jqXHR) {
		current_content_id = GetMenuCount('scene');
		var new_scene_title = response['title'];
		$('#next_scene_spot').replaceWith(
		 	('<li class=\'odd\'>'+
				'<a href="#" onclick="switchEditor(\''+current_content_id+'\',\'scene\')">'+
					'<span id="editor_cssmenu_scene_'+current_content_id+'">'+new_scene_title+'</span>'+
				'</a>'+
			 '</li><div id=\'next_scene_spot\'></div>'));
		UpdateCssMenuCounts();
		switchToNewEditor(current_content_id, 'scene');
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function newCharacter()
{
	request = $.ajax({
		url: "ajax/new_character_editor_content.php",
		type: "POST",
		dataType: "json"
	});
	
	request.done(function (response, textStatus, jqXHR) {
		current_content_id = GetMenuCount('character');
		var new_character_name = response['name'];
		$('#next_character_spot').replaceWith(
		 	('<li class=\'odd\'>'+
				'<a href="#" onclick="switchEditor(\''+current_content_id+'\',\'character\')">'+
					'<span id="editor_cssmenu_character_'+current_content_id+'">'+new_character_name+'</span>'+
				'</a>'+
			 '</li><div id=\'next_character_spot\'></div>'));
		UpdateCssMenuCounts();
		switchToNewEditor(current_content_id, 'character');
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function newLocation()
{
	request = $.ajax({
		url: "ajax/new_location_editor_content.php",
		type: "POST",
		dataType: "json"
	});
	
	request.done(function (response, textStatus, jqXHR) {
		current_content_id = GetMenuCount('location');
		var new_location_title = response['title'];
		$('#next_location_spot').replaceWith(
		 	('<li class=\'odd\'>'+
				'<a href="#" onclick="switchEditor(\''+current_content_id+'\',\'location\')">'+
					'<span id="editor_cssmenu_location_'+current_content_id+'">'+new_location_title+'</span>'+
				'</a>'+
			 '</li><div id=\'next_location_spot\'></div>'));
		UpdateCssMenuCounts();
		switchToNewEditor(current_content_id, 'location');
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function switchToNewEditor(content_id, content_type)
{
	$('#editor').waiting();
	
	$('#editor_document').attr('name', content_type);
	
	loadEditorContent(content_id, content_type);
}

function switchEditor(content_id, content_type)
{
	$('#editor').waiting();
	
	console.log("wait");
	
	saveEditorContent();
	
	console.log("saving");
	
	$('#editor_document').attr('name', content_type);
	
	loadEditorContent(content_id, content_type);
	
	console.log("loading");
}

function saveEditorContent()
{	
	if(IsTest)
		return;
	var content_type = $('#editor_document').attr('name');
	switch(content_type)
	{
		case "scene":
			AppySceneTitleChange();
			saveSceneContent();
			break;
		case "character":
			AppyCharacterNameChange();
			saveCharacterContent();
			break;
		case "location":
			AppyLocationTitleChange();
			saveLocationContent();
			break;
		default:
			break;
	}
}

function saveSceneContent()
{
	var scene_content = $('#scene_content_textarea').html();
	var scene_title = $('#scene_title_textarea').html();
	
	request = $.ajax({
		url: "ajax/save_scene_editor_content.php",
		type: "POST",
		data: {"scene_id" : current_content_id,
			   "title" : scene_title,
			   "scene_content" : scene_content,
			   "current_time" : getTimeStamp()}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		projectEdited();
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function AppySceneTitleChange()
{
	var new_title = $('#scene_title_textarea').html();
	$('#editor_cssmenu_scene_'+current_content_id).html(new_title);
}

function saveCharacterContent()
{
	var shortname = $('#character_shortname_textarea').html();
	var fullname = $('#character_fullname_textarea').html();
	var altnames = $('#character_altnames_textarea').html();
	var description = $('#character_description_textarea').html();
	var significance = $('#character_significance_textarea').html();
	
	request = $.ajax({
		url: "ajax/save_character_editor_content.php",
		type: "POST",
		data: {"character_id" : current_content_id,
			   "short_name" : shortname,
			   "full_name" : fullname,
			   "alt_names" : altnames,
			   "description" : description,
			   "significance" : significance,
			   "current_time" : getTimeStamp()}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		projectEdited();	
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function AppyCharacterNameChange()
{
	var new_name = $('#character_fullname_textarea').html();
	$('#editor_cssmenu_character_'+current_content_id).html(new_name);
}

function saveLocationContent()
{
	var title = $('#location_title_textarea').html();
	var alt_titles = $('#location_alt_titles_textarea').html();
	var description = $('#location_description_textarea').html();
	
	request = $.ajax({
		url: "ajax/save_location_editor_content.php",
		type: "POST",
		data: {"location_id" : current_content_id,
			   "title" : title,
			   "alt_titles" : alt_titles,
			   "description" : description,
			   "current_time" : getTimeStamp()}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		projectEdited();
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function AppyLocationTitleChange()
{
	var new_title = $('#location_title_textarea').html();
	$('#editor_cssmenu_location_'+current_content_id).html(new_title);
}

function projectEdited()
{
	request = $.ajax({
		url: "ajax/update_project_last_edited.php",
		type: "POST",
		data: {"current_time" : getTimeStamp()}
	});
	
	request.done(function (response, textStatus, jqXHR) {
		setProjectLastSavedState();
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}

function setProjectLastSavedState()
{
	$('#editor_toolbar_project_save_state').html('<a href="#save" class="light_toolbar_link">Saved '+getTimeStamp()+'</a>');
}
	
$(window).bind('keydown', function(event) {
if (event.ctrlKey || event.metaKey) {
	switch (String.fromCharCode(event.which).toLowerCase()) {
	case 's':
		event.preventDefault();
		saveEditorContent();
		break;
	}
}
});

function getTimeStamp() 
{
   var now = new Date();
   return ((now.getMonth() + 1) + '/' + (now.getDate()) + '/' + now.getFullYear() + " " + now.getHours() + ':'
				 + ((now.getMinutes() < 10) ? ("0" + now.getMinutes()) : (now.getMinutes())) + ':' + ((now.getSeconds() < 10) ? ("0" + now.getSeconds()) : (now.getSeconds())));
}

$(document).ready(function()
{
	CreateCssMenuCounts();
	
	$('#cssmenu ul ul li:odd').addClass('odd');
	$('#cssmenu ul ul li:even').addClass('even');
	
	$('#cssmenu > ul > li > a').click(function() 
	{
	  $(this).closest('li').addClass('active');	
	  var checkElement = $(this).next();
	  
	  if((checkElement.is('ul')) && (checkElement.is(':visible'))) 
	  {
		$(this).closest('li').removeClass('active');
		checkElement.slideUp('normal');
	  }
	  
	  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) 
	  {
		checkElement.slideDown('normal');
	  }
	  
	  if($(this).closest('li').find('ul').children().length == 0) {return true;} 
	  else {return false;}		
	});
});	


function CreateCssMenuCounts()
{
	$('#cssmenu > ul > li ul').each(function(index, e)
	{
	  var count = $(e).find('li').length-1;
	  var content = '<span class="cnt">' + count + '</span>';
	  $(e).closest('li').children('a').append(content);
	});
}

function UpdateCssMenuCounts()
{
	$("#scenes_menu_top").find(".cnt").html(GetMenuCount("scene"));
	$("#characters_menu_top").find(".cnt").html(GetMenuCount("character"));
	$("#locations_menu_top").find(".cnt").html(GetMenuCount("location"));
}

function GetMenuCount(content_type)
{
	return $('#cssmenu_'+content_type+'s').find('li').length-1;
}

function ToggleRevisionsDropDown()
{
	$("#editor_revisions_display").slideToggle('fast');
}