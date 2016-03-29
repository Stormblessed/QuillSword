<?php

	class SecurityMapping
	{	
		private $mappings = array(); 
		
		function __construct($table_name, $check_field, $field_id) 
		{
			$this->LoadMappingsFromDb($table_name, $check_field, $field_id);
    	}
		
		public function LoadMappingsFromDb($table_name, $check_field, $field_id)
		{
			$data = mysql_query("SELECT id FROM $table_name WHERE $check_field=$field_id") or die(mysql_error());
			while($item = mysql_fetch_array($data))
			{
				$this->mappings[] = $item['id'];
			}
		}
		
		public function Internalize($external_id)
		{
			return $this->mappings[$external_id];
		}
		
		public function Externalize($internal_id)
		{
			return array_search($internal_id, $this->mappings);
		}
		
		public function Mappings()
		{
			return $this->mappings;
		}
	}

?>