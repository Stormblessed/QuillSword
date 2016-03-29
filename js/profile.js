// JavaScript Document

	var description, genres, books, authors;
	
	function TogglePosts()
	{
		$(".profile_feed_section").slideToggle('fast');
		if($("#profile_toggle_posts").html() == "Show Posts")
			$("#profile_toggle_posts").html("Hide Posts");
		else
			$("#profile_toggle_posts").html("Show Posts");
	}
	
	function ToggleFollow(target_id, target_name)
	{
		if(target_name.length > 0)
			ToggleFollowLinkText(target_name);
		else
			ToggleUsersFollowRow(target_id);
		
		request = $.ajax({
			url: "ajax/togglefollow.php",
			type: "POST",
			data: {"target_id" : target_id}
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
	
	function ToggleFollowLinkText(target_name)
	{
		if($('#toggle_follow_link').html().indexOf('Unfollow') > -1)
			$('#toggle_follow_link').html('Follow ' + target_name);
		else
			$('#toggle_follow_link').html('Unfollow ' + target_name);
	}
	
	function ToggleUsersFollowRow(target_id)
	{
		if($('.follow_user_'+target_id).html().indexOf('Unfollow') > -1)
		{
			$('.follow_user_'+target_id).html('Follow');
			UpdateFollowingCountBy(-1);
		}
		else
		{
			$('.follow_user_'+target_id).html('Unfollow');
			UpdateFollowingCountBy(1);
		}
	}
	
	function UpdateFollowingCountBy(value)
	{
		$('#following_count').html(parseInt($('#following_count').html()) + value);
	}
	
	function ToggleEditing()
	{
		if($('#toggle_edit_profile').html().indexOf('Cancel') > -1)
		{
			$('#toggle_edit_profile').html('Edit Profile');
			RevertProfileFormsToContentVars();
		}
		else
		{
			$('#toggle_edit_profile').html('Cancel Editing');
			SetProfileFormContentVars();
		}
		$('#save_edits_profile').slideToggle('fast');
		ToggleForms();
	}
	
	function ToggleForms()
	{
		var $div=$('.profile_section_text'), isEditable=$div.is('.profile_editable');
    	$('.profile_section_text').prop('contenteditable',!isEditable).toggleClass('profile_editable');		
	}
	
	function SaveEdits()
	{
		SetProfileFormContentVars();
		
		request = $.ajax({
			url: "ajax/update_user_profile.php",
			type: "POST",
			data: {"description" : description,
				   "genres"      : genres,
				   "books"       : books,
				   "authors"     : authors}
		});
		
		request.done(function (response, textStatus, jqXHR) {
		});
		
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occured: "+
				textStatus, errorThrown
			);
		});
		ToggleEditing();
	}
	
	function SetProfileFormContentVars()
	{
		description = $('#profile_description_text').html();
		genres = $('#profile_genres_text').html();
		books = $('#profile_books_text').html();
		authors = $('#profile_authors_text').html();
	}
	
	function RevertProfileFormsToContentVars()
	{
		$('#profile_description_text').html(description);
		$('#profile_genres_text').html(genres);
		$('#profile_books_text').html(books);
		$('#profile_authors_text').html(authors);
	}
	