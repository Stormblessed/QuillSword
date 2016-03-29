<?php
		
	class Revision
	{		
		function __construct() 
		{
    	}
		
		function RevisionSavedDateString()
		{
			$DateTime = DateTime::createFromFormat('M d, Y, H:i:s  a');
			return $DateTime->format('M d, Y');
		}
						
	}
?>