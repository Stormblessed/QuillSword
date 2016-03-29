<?php
	
	require_once('MappingHub.php');
	
	class ProjectMappings extends MappingHub
	{			
		function __construct($project_id)
		{
			parent::__construct('projectid', $project_id);
			$this->LoadMappings();
		}
				
		private function LoadMappings()
		{
			$this->LoadMapping('scenes');
			$this->LoadMapping('characters');
			$this->LoadMapping('locations');
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