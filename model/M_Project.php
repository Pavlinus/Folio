<?php

class M_Project
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
			self::$instance = new M_Project();
		}
		
		return self::$instance;
	}
	
	
	public function Add()
	{
		$params = array(
			'user_id' => $_COOKIE['user_id'],
			'name' => mysql_real_escape_string($_POST['name']),
			'description' => mysql_real_escape_string($_POST['description']),
			'link' => mysql_real_escape_string($_POST['link']),
			'image' => mysql_real_escape_string("../images/example.png"));
	
		return $this->msql->Insert('projects', $params);
	}
	
	
	public function Get($project_id)
	{
		$query = "SELECT * FROM projects WHERE project_id = $project_id";
		return $this->msql->Select($query);
	}
	
	
	public function Del($project_id)
	{
		$where = "project_id = $project_id";
		
		return $this->msql->Delete('projects', $where);
	}
	
	
	public function All($user_id)
	{
		$query = "SELECT * FROM projects WHERE user_id = $user_id 
				ORDER BY project_id DESC";
		return $this->msql->Select($query);
	}
	
	
	public function Update($project_id)
	{
		$object = array("name" => mysql_real_escape_string($_REQUEST['name']),
						"description" => mysql_real_escape_string($_REQUEST['description']),
						"link" => mysql_real_escape_string($_REQUEST['link']),
						/*"img" => mysql_real_escape_string($_REQUEST['img'])*/
						"image" => mysql_real_escape_string("../images/example.png"));
						
		$where = "project_id = $project_id";
		
		return $this->msql->Update("projects", $object, $where);
	}
}
?>