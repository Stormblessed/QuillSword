<?php
	
	require_once('Post.php');
	
	class PostFeed
	{
		private $Posts = array();
		
		function __construct() 
		{
    	}
				
		public function LoadPosts($user_id, $group)
		{
			$postsTable = "posts";
			$followTable = "follows";
			
			if($group == "Following")
				$data = mysql_query(
									"SELECT id
									 FROM $postsTable
									 WHERE userid
									 IN 
									 (
									    SELECT target_id
									  	FROM $followTable
										WHERE userid = $user_id
										AND 
									 	TYPE =  'user'
									 )
									 OR userid = $user_id
									 ORDER BY creation DESC"
									) or die(mysql_error());
			else
				$data = mysql_query("SELECT id FROM $postsTable WHERE group_name='$group' ORDER BY creation DESC") or die(mysql_error());
			
			while($post = mysql_fetch_array($data))
			{
				$this->Posts[] = new Post($post['id']);
			}			
		}
		
		public function LoadUsersPosts($user_id)
		{
			$postsTable = "posts";
			$data = mysql_query("SELECT id FROM $postsTable WHERE userid='$user_id' ORDER BY creation DESC") or die(mysql_error());
			while($post = mysql_fetch_array($data))
			{
				$this->Posts[] = new Post($post['id']);
			}	
		}
		
		public function Posts()
		{
			return $this->Posts;
		}
	}
?>