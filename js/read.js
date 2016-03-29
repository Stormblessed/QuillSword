// JavaScript Document

var SelectedPanelOpen = false;
function OpenSelectedPanel(project_id)
{
	if(!SelectedPanelOpen)
		$("#read_selected_panel").slideDown();
	LoadProjectIntoSelectedPanel(project_id);
}

function LoadProjectIntoSelectedPanel(project_id)
{
	request = $.ajax({
		url: "ajax/load_read_selected_project.php",
		type: "POST",
		dataType:"json",
		data: {"project_id" : project_id}
	});
	
	request.done(function (response, textStatus, jqXHR) {
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error(
			"The following error occured: "+
			textStatus, errorThrown
		);
	});
}