// JavaScript Document

	function openProject(project_id)
	{
		window.location = "write.php?projectid=" + project_id;
	}
	
	function NewLocationDropdown()
	{
		$('.new_post_location_options').slideToggle('fast');
	}
	
	function SwitchLocation(new_location)
	{
		$('.new_post_location_header').html(new_location);
		$('.new_post_hidden').val(new_location);
		$('.new_post_location_options').slideToggle('fast');
	}
		
	InstantClick.on('change', function() 
	{
		LoadHomeMasonry();
	});
	
	$(window).load(function(){
		LoadHomeMasonry();
	});
		
	function LoadHomeMasonry()
	{
		var $container = $('#home_feed_content_section');
		$container.masonry({
			columnWidth: 382,
			itemSelector: '.home_feed_post_block'
		});
	}	