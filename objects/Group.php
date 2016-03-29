<?php
		
	class Group
	{
		private $GroupTraits = array();
		
		function __construct($group_id) 
		{
			$this->loadAttributesFromDb($group_id);
    	}
				
		public function loadAttributesFromDb($group_id)
		{
			$groupsTable = "groups";
			$data = mysql_query(
								"SELECT 
									*
								 FROM 
								 	$groupsTable
								 WHERE 
								 	id=$group_id"
								) or die(mysql_error());
			$this->GroupTraits = mysql_fetch_array($data);
		}
				
		public function GroupId()
		{
			return $this->GroupTraits['id'];
		}
				
		public function CreatorId() 
		{
			return $this->GroupTraits['creator_id'];
		}
				
		public function Name()
		{
			return $this->GroupTraits['name'];
		}
		
		public function Description() 
		{
			return $this->GroupTraits['description'];
		}
		
		public function Type() 
		{
			return $this->GroupTraits['type'];
		}
				
		public function Creation() 
		{
			return $this->GroupTraits['creation'];
		}	
		
		public function LastActive() 
		{
			return $this->GroupTraits['last_active'];
		}	
		
		public function SavedByCount()
		{
			$savedGroupsTable = "saved_groups";
			$group_id = $this->GroupId();
			
			$data = mysql_query(
								"SELECT
									id
								 FROM
								 	$savedGroupsTable
								 WHERE
								 	group_id='$group_id'
								"
								);
			return mysql_num_rows($data);
		}
		
		public function IsSavedBy($user_id)
		{
			$group_id = $this->GroupId();
			$savedGroupsTable = "saved_groups";
			$data = mysql_query("SELECT id FROM $savedGroupsTable WHERE userid=$user_id AND group_id='$group_id'");
			
			if(mysql_num_rows($data) > 0)
				return true;
			return false;
		}
		
		//Come up with a better solution to the options issue.  This one is stupid.
		public function WriteOptions($user_id)
		{
			$Options = "";
			if($this->Name() != "Following" && $this->Name() != "Followers")
			{
				$Options .= $this->SaveOption($user_id);
				$Options .= $this->ShareOption($user_id);
			}
			return $Options;
		}
        
        private function SaveOption($user_id)
        {
			if(!$this->IsSavedBy($user_id))
			{
				return '
					<a href="#" id="toggle_group_'.$this->GroupId().'" class="home_feed_control_panel_option" title="Save Group" onclick="ToggleSaveGroup('.$this->GroupId().'); return false;">
						<i class="fa fa-floppy-o"></i>
					</a>
					 ';
			}
			return '
					<a href="#" id="toggle_group_'.$this->GroupId().'" class="home_feed_control_panel_option" title="Remove Group" onclick="ToggleSaveGroup('.$this->GroupId().'); return false;">
						<i class="fa fa-times"></i>
					</a>
				   ';
        }
		
		private function ShareOption($user_id)
		{
			return '
					<a href="#" class="home_feed_control_panel_option" title="Share Group">
						<i class="fa fa-share-square"></i>
					</a>
				   ';
		}
	}
?>