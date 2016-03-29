// JavaScript Document

var title, genres, description, last_toggled_project = -1;

function newProjectDropDown()
{
	$("#new_projects_dropdown").slideToggle();
}

function openProject(project_id)
{
	window.location = "write.php?projectid=" + project_id;
}

function toggleProjectDropDown(project_id)
{
	if(last_toggled_project != project_id)
	{
		$('.projects_display_project_content').slideUp();
		$('#project_dropdown_'+project_id).slideToggle();
	}
	else
	{
		$('#project_dropdown_'+project_id).slideToggle();
	}
	last_toggled_project = project_id;
}

function ToggleProjectEditing(project_id)
{
	if($('.toggle_project_edit_'+project_id).html().indexOf('Cancel') > -1)
	{
		$('.toggle_project_edit_'+project_id).html('Edit Project Info');
		RevertProjectFormsToContentVars(project_id);
	}
	else
	{
		$('.toggle_project_edit_'+project_id).html('Cancel Editing');
		SetProjectFormContentVars(project_id);
	}
	$('.save_project_edits_'+project_id).slideToggle('fast');
	ToggleProjectForms();
}

function ToggleProjectForms()
{
	var $div=$('.project_display_main_text'), isEditable=$div.is('.project_editable');
	$('.project_display_main_text').prop('contenteditable',!isEditable).toggleClass('project_editable');		
}

function SaveProjectInfoEdits(project_id)
{
	SetProjectFormContentVars(project_id);
	
	request = $.ajax({
		url: "ajax/update_project_info.php",
		type: "POST",
		data: {"project_id"  : project_id,
			   "title"       : title,
			   "genres"      : genres,
			   "description" : description}
	});
	
	request.done(function (response, textStatus, jqXHR) {
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
	ToggleProjectEditing(project_id);
}

function SetProjectFormContentVars(project_id)
{
	title = $('#project_title_'+project_id).html();
	genres = $('#project_genre_'+project_id).html();
	description = $('#project_description_'+project_id).html();
}

function RevertProjectFormsToContentVars(project_id)
{
	$('#project_title_'+project_id).html(title);
	$('#project_genre_'+project_id).html(genres);
	$('#project_description_'+project_id).html(description);
}