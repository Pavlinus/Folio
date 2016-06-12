<?php

class M_Search
{
	private static $instance;
	private $msql;
	
	function __construct()
	{
		$this->msql = M_MSQL::Instance();
	}
	
	public function Instance()
	{
		if(self::$instance == null)
		{
			self::$instance = new M_Search();
		}
		
		return self::$instance;
	}

	public function GetNewProjects()
	{
		$query = "SELECT * FROM projects ORDER BY project_id DESC LIMIT 10";
		return $this->msql->Select($query);
	}
	
	public function GetProjectsByType($type)
	{
		
		$query = "SELECT * FROM projects WHERE speciality = {$type} ORDER BY project_id DESC LIMIT 10";
		return $this->msql->Select($query);
	}
}

?>