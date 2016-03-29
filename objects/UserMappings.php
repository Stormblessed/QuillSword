<?php
	
	require_once('MappingHub.php');
	
	class UserMappings extends MappingHub
	{			
		function __construct($user_id)
		{
			parent::__construct('userid', $user_id);
			$this->LoadMappings();
		}
				
		private function LoadMappings()
		{
			$this->LoadMapping('projects');
			$this->LoadMapping('scenes');
			$this->LoadMapping('characters');
			$this->LoadMapping('locations');
		}
		
		public function ProjectMappings()
		{
			return $this->FetchMapping('projects');
		}
		
		public function SceneMappings()
		{
			return $this->FetchMapping('scenes');
		}
		
		public function CharacterMappings()
		{
			return $this->FetchMapping('characters');
		}
		
		public function LocationMappings()
		{
			return $this->FetchMapping('locations');
		}
	}

?>