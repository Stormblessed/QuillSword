// JavaScript Document

	function CreateGroupDropDown()
	{
		$('#create_group_form').slideToggle('fast');
	}
	
	function ToggleSaveGroup(group_id)
	{
		ToggleGroupSwitchIcons(group_id);
		
		request = $.ajax({
			url: "ajax/toggle_saved_group.php",
			type: "POST",
			data: {"group_id" : group_id}
		});
		
		request.done(function (response, textStatus, jqXHR) {
			console.log(response);
		});
		
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occured: "+
				textStatus, errorThrown
			);
		});
	}
	
	function ToggleGroupSwitchIcons(group_id)
	{
		if($('#toggle_group_'+group_id).attr("title").indexOf("Remove") > -1)
		{
			$('#toggle_group_'+group_id).attr("title", "Save Group");
			$('#toggle_group_'+group_id).html('<i class="fa fa-floppy-o"></i>');
		}
		else
		{
			$('#toggle_group_'+group_id).attr("title", "Remove Group");
			$('#toggle_group_'+group_id).html('<i class="fa fa-times"></i>');
		}
	}