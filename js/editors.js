// JavaScript Document

	CKEDITOR.disableAutoInline = false;
	InstantiateSceneEditors();
	InstantiateCharacterEditors();
	InstantiateLocationEditors();
	
	function InstantiateSceneEditors()
	{
		var scene_editor = CKEDITOR.inline( 'scene_title_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var scene_editor = CKEDITOR.inline( 'scene_content_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
	}
	
	function InstantiateCharacterEditors()
	{
		var character_shortname_editor = CKEDITOR.inline( 'character_shortname_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var character_fullname_editor = CKEDITOR.inline( 'character_fullname_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var character_altnames_editor = CKEDITOR.inline( 'character_altnames_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var character_description_editor = CKEDITOR.inline( 'character_description_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var character_significance_editor = CKEDITOR.inline( 'character_significance_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
	}
	
	function InstantiateLocationEditors()
	{
		var location_title_editor = CKEDITOR.inline( 'location_title_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var location_alt_titles_editor = CKEDITOR.inline( 'location_alt_titles_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
		
		var location_description_editor = CKEDITOR.inline( 'location_description_textarea', {
		extraPlugins: 'sharedspace',
		removePlugins: 'floatingspace,resize',
		sharedSpaces: {
			top: 'editor_toolbar_ck',
			bottom: 'editor_bottom'
			}
		});
	}
	
	function SwitchEditorInstantiations(content_type)
	{
		if(first_editor_load)
			return;
		
		DestroyAllEditors();
		
		switch(content_type)
		{
			case "scene":
				InstantiateSceneEditors();
				break;
			case "character":
				InstantiateCharacterEditors();
				break;
			case "location":
				InstantiateLocationEditors();
				break;
			default:
				break;
		}
	}
	
	function DestroyAllEditors()
	{
		for(k in CKEDITOR.instances)
		{
			var instance = CKEDITOR.instances[k];
			instance.destroy();
		}
	}