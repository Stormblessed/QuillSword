<?php
	
	require_once('Group.php');
	
	class GroupFeed
	{
		private $Groups = array();
		
		function __construct() 
		{
    	}
				
		public function LoadGroups($user_id)
		{
			$groupsTable = "groups";
			
			$data = mysql_query(
								"SELECT
									id
								 FROM
								 	$groupsTable
								 WHERE
								 	id != 1 AND
									id != 2
								 ORDER BY creation DESC
								"
								);
			
			while($group = mysql_fetch_array($data))
			{
				$this->Groups[] = new Group($group['id']);
			}			
		}
		
		public function LoadPopularGroupsWithLimit($limit)
		{
			$savedGroupsTable = "saved_groups";
			
			$data = mysql_query(
								"SELECT
									group_id, count(group_id) as cnt
								 FROM
								 	$savedGroupsTable
								 GROUP BY group_id
								 ORDER BY cnt DESC LIMIT $limit
								"
								);
											
			while($group = mysql_fetch_array($data))
			{
				$this->Groups[] = new Group($group['group_id']);
			}			
		}
		
		public function Groups()
		{
			return $this->Groups;
		}
	}
?>