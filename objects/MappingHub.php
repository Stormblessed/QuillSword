<?php
	
	require_once('SecurityMapping.php');
	
	class MappingHub
	{	
		private $field_name;
		private $field_id;
		private $mappings = array();
		
		function __construct($field_name, $field_id)
		{
			$this->SetFieldName($field_name);
			$this->SetFieldId($field_id);
		}
		
		protected function SetFieldName($field_name)
		{
			$this->field_name = $field_name;
		}
		
		protected function SetFieldId($field_id)
		{
			$this->field_id = $field_id;
		}
				
		public function LoadMapping($table_name)
		{
			$this->mappings[$table_name] = new SecurityMapping($table_name, $this->field_name, $this->field_id);
		}
		
		public function FetchMapping($table_name)
		{
			return $this->mappings[$table_name];
		}
	}

?>