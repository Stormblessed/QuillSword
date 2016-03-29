<?php
	
	require_once('ProjectMappings.php');
	
	class Project
	{
		private $ProjectTraits = array();
		private $SecurityMapping;
		
		public $ProjectMappings;
		
		function __construct() 
		{
    	}
		
		public static function WithInternalId($project_id)
		{
			$instance = new self();
			$instance->LoadFromInternalId($project_id);
			return $instance;
		}
		
		public static function WithExternalId($project_id) 
		{
    		$instance = new self();
    		$instance->LoadFromExternalId($project_id);
    		return $instance;
    	}
		
		protected function LoadFromInternalId($project_id)
		{
			$this->SecurityMapping = new SecurityMapping('projects', 'userid', $_SESSION['userid']);
			$this->loadAttributesFromDb($project_id);
			$this->LoadMappings();
		}
		
		protected function LoadFromExternalId($project_id)
		{
			$this->SecurityMapping = new SecurityMapping('projects', 'userid', $_SESSION['userid']);
			$this->loadAttributesFromDb($this->SecurityMapping->Internalize($project_id));
			$this->LoadMappings();
		}
		
		public function loadAttributesFromDb($project_id)
		{
			$tableName = "projects";
			$data = mysql_query("SELECT * FROM $tableName WHERE id=$project_id") or die(mysql_error());
			$this->ProjectTraits = mysql_fetch_array($data);
		}
		
		public function LoadMappings()
		{
			$this->ProjectMappings = new ProjectMappings($this->InternalProjectId());
		}
		
		public function fetchSceneList()
		{
			$sceneTable = "scenes";
			$project_id = $this->InternalProjectId();
			$data = mysql_query("SELECT * FROM $sceneTable WHERE projectid=$project_id") or die(mysql_error());
			return $data;
		}
		
		public function fetchCharacterList()
		{
			$characterTable = "characters";
			$project_id = $this->InternalProjectId();
			$data = mysql_query("SELECT * FROM $characterTable WHERE projectid=$project_id") or die(mysql_error());
			return $data;
		}
		
		public function fetchLocationList()
		{
			$locationTable = "locations";
			$project_id = $this->InternalProjectId();
			$data = mysql_query("SELECT * FROM $locationTable WHERE projectid=$project_id") or die(mysql_error());
			return $data;
		}
		
		public function UserId()
		{
			return $this->ProjectTraits['userid'];
		}
		
		public function InternalProjectId()
		{
			return $this->ProjectTraits['id'];
		}
		
		public function ProjectId() 
		{
			return $this->SecurityMapping->Externalize($this->ProjectTraits['id']);
		}
		
		public function Title() 
		{
			return $this->ProjectTraits['title'];
		}
		
		public function Genre()
		{
			return $this->ProjectTraits['genre'];
		}
		
		public function Description() 
		{
			return $this->ProjectTraits['description'];
		}
		
		public function Privacy() 
		{
			return $this->ProjectTraits['privacy'];
		}
		
		public function Status() 
		{
			return $this->ProjectTraits['status'];
		}
		
		public function Creation() 
		{
			return $this->ProjectTraits['creation'];
		}
		
		public function LastEdited()
		{
			if ($this->ProjectTraits['last_edited'] == '0000-00-00 00:00:00') 
				return 'Not yet saved.';
			return $this->ProjectTraits['last_edited'];
		}		
		
		public function IsFirstLoad()
		{
			if($this->LastEdited() == 'Not yet saved.')
				return true;
			return false;
		}
	}
?>