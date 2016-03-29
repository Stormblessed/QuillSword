<?php
		
	class Post
	{
		private $PostTraits = array();
		
		function __construct($post_id) 
		{
			$this->loadAttributesFromDb($post_id);
    	}
				
		public function loadAttributesFromDb($post_id)
		{
			$postsTable = "posts";
			$usersTable = "users";
			$data = mysql_query(
								"SELECT 
									p.*, u.last_name, u.first_name
								 FROM 
								 	$postsTable as p 
								 LEFT JOIN $usersTable as u ON p.userid = u.id
								 WHERE 
								 	p.id=$post_id"
								) or die(mysql_error());
			$this->PostTraits = mysql_fetch_array($data);
		}
				
		public function PostId()
		{
			return $this->PostTraits['id'];
		}
				
		public function UserId() 
		{
			return $this->PostTraits['userid'];
		}
		
		public function UserFullName()
		{
			return $this->PostTraits['first_name']." ".$this->PostTraits['last_name'];
		}
		
		public function TargetId()
		{
			return $this->PostTraits['target_id'];
		}
		
		public function GroupName() 
		{
			return $this->PostTraits['group_name'];
		}
		
		public function GroupId()
		{
			$group_name = $this->GroupName();
			$groupsTable = "groups";
			$data = mysql_query(
								"
								SELECT
									id
								FROM
									$groupsTable
								WHERE
									name='$group_name'
								"
								);
			$group = mysql_fetch_array($data);
			return $group['id'];
		}
		
		public function Content() 
		{
			return $this->PostTraits['content'];
		}
				
		public function Creation() 
		{
			return $this->PostTraits['creation'];
		}	
	}
?>