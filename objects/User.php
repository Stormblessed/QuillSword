<?php

	require_once('UserMappings.php');
	require_once('Group.php');
	
	class User
	{
		private $UserTraits = array();
		private $UserMappings;
		
		function __construct($user_id) 
		{
			$this->LoadAttributesFromDb($user_id);
			$this->LoadUserMappings($user_id);
    	}
		
		public function LoadAttributesFromDb($user_id)
		{
			$tableName = "users";
			$data = mysql_query("SELECT * FROM $tableName WHERE id=$user_id") or die(mysql_error());
			
			$this->UserTraits = mysql_fetch_array($data);
		}
		
		public function LoadUserMappings($user_id)
		{
			$this->UserMappings = new UserMappings($user_id);
		}
		
		public function Projects()
		{
			$projects_to_return = array();
			$user_id = $this->UserId();
			
			$tableName = "projects";
			$data = mysql_query("SELECT id FROM $tableName WHERE userid=$user_id ORDER BY last_edited DESC") or die(mysql_error());
			
			while($project = mysql_fetch_array($data))
			{
				$projects_to_return[] = Project::WithInternalId($project['id']);
			}
			
			return $projects_to_return;
		}
		
		public function ProjectsWithLimit($limit)
		{
			$projects_to_return = array();
			$user_id = $this->UserId();
			
			$tableName = "projects";
			$data = mysql_query("SELECT id FROM $tableName WHERE userid=$user_id ORDER BY last_edited DESC LIMIT $limit") or die(mysql_error());
			
			while($project = mysql_fetch_array($data))
			{
				$projects_to_return[] = Project::WithInternalId($project['id']);
			}
			
			return $projects_to_return;
		}
		
		public function SavedGroups()
		{
			$groups_to_return = array();
			$user_id = $this->UserId();
			
			$groupsTable = "groups";
			$savedGroupsTable = "saved_groups";
			
			$data = mysql_query("
								SELECT id
							 	FROM $groupsTable
								WHERE id
								IN 
								(
									SELECT group_id
									FROM $savedGroupsTable
									WHERE userid = $user_id
								)
								ORDER BY creation DESC"
								);
																			
			while($group = mysql_fetch_array($data))
			{
				$groups_to_return[] = new Group($group['id']);
			}
			
			return $groups_to_return;
		}
		
		public function FollowingUsers()
		{
			$users_to_return = array();
			$user_id = $this->UserId();
			
			$followsTable = "follows";
			
			$data = mysql_query("SELECT target_id FROM $followsTable WHERE userid='$user_id' ORDER BY creation DESC");
			
			while($user = mysql_fetch_array($data))
			{
				$users_to_return[] = new User($user['target_id']);
			}
			return $users_to_return;
		}
		
		public function FollowedUsers()
		{
			$users_to_return = array();
			$user_id = $this->UserId();
			
			$followsTable = "follows";
			
			$data = mysql_query("SELECT userid FROM $followsTable WHERE target_id='$user_id' ORDER BY creation DESC");
			
			while($user = mysql_fetch_array($data))
			{
				$users_to_return[] = new User($user['userid']);
			}
			return $users_to_return;
		}
		
		public function IsFollowingUser($target_id)
		{
			$user_id = $this->UserId();
			
			$followsTable = "follows";
			$data = mysql_query("SELECT id FROM $followsTable WHERE target_id='$target_id' AND userid='$user_id'");
			
			if(mysql_num_rows($data) > 0)
				return true;
			return false;
		}
		
		public function IsFollowingGroup($group_id)
		{
			$user_id = $this->UserId();
			
			$savedGroupsTable = "saved_groups";
			$data = mysql_query("SELECT id FROM $savedGroupsTable WHERE userid='$user_id' AND group_id='$group_id'");
			
			if(mysql_num_rows($data) > 0)
				return true;
			return false;
		}
		
		public function UserId()
		{
			return $this->UserTraits['id'];
		}
		
		public function LastName()
		{
			return $this->UserTraits['last_name'];
		}
		
		public function FirstName()
		{
			return $this->UserTraits['first_name'];
		}
		
		public function FullName()
		{
			return $this->FirstName()." ".$this->LastName();
		}
		
		public function EmailAddress()
		{
			return $this->UserTraits['email'];
		}
		
		public function Level()
		{
			return $this->UserTraits['level'];
		}
		
		public function Experience()
		{
			return $this->UserTraits['experience'];
		}	
		
		public function Description()
		{
			return $this->UserTraits['description'];
		}
		
		public function Genres()
		{
			return $this->UserTraits['genres'];
		}
		
		public function Books()
		{
			return $this->UserTraits['books'];
		}
		
		public function Authors()
		{
			return $this->UserTraits['authors'];
		}
		
		public function Online()
		{
			return $this->UserTraits['online'];
		}
		
		public function Creation()
		{
			return $this->UserTraits['creation'];
		}
		
		public function UserMappings()
		{
			return $this->UserMappings;
		}
	}
?>