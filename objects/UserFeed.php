<?php
	
	require_once('User.php');
	
	class UserFeed
	{
		private $Users = array();
		
		function __construct() 
		{
    	}
				
		public function LoadUsersWithSimilarName($search_name)
		{
			$usersTable = "users";
			
			$data = mysql_query(
								"SELECT
									id
								 FROM
								 	$usersTable
								 WHERE
								 	first_name LIKE '%$search_name%' OR
									last_name LIKE '%$search_name%'
								 ORDER BY creation DESC
								 LIMIT 5
								"
								);
			
			while($user = mysql_fetch_array($data))
			{
				$this->Users[] = new User($user['id']);
			}			
		}
				
		public function Users()
		{
			return $this->Users;
		}
	}
?>