<?php

class M_Project
{
	private static $instance;
	private $msql;
	private $keysArray = array('name', 
							   'description', 
							   'link',
							   'type');
	
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
	
	
	public function GetById($id)
	{
		$query = "SELECT * FROM projects WHERE 
					project_id = $id";
		
		return $this->msql->Select($query);
	}
	
	
	public function Add()
	{
		$mUser = M_User::Instance();
		$user = $mUser->GetById($_COOKIE['user_id']);
		
		if($_FILES['image']['name'] != "")
		{			
			$image_handler = ImageHandler::Instance();
			$image = $image_handler->UploadImage($_FILES['image'], $user[0]['login']);
		}
		else
		{
			$image = "../images/project_default.png";
		}
		
		$params = array(
			'user_id' => $_COOKIE['user_id'],
			'image' => mysql_real_escape_string($image['orig']));
			
		foreach($this->keysArray as $val)
		{
			$params[$val] = mysql_real_escape_string(trim($_POST[$val]));
		}
	
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
		$object = $this->ProjectUpdateArray($project_id);
		$where = "project_id = $project_id";
		
		return $this->msql->Update("projects", $object, $where);
	}
	
	
	private function ProjectUpdateArray($id)
	{
		$mUser = M_User::Instance();
		$user = $mUser->GetById($_COOKIE['user_id']);
		
		// Выбрано изображение
		if($_FILES['image']['name'] != "")
		{			
			$image_handler = ImageHandler::Instance();
			$img_arr = $image_handler->UploadImage($_FILES['image'], $user[0]['login']);
			$image = $img_arr['orig'];
		}
		else
		{
			$project = $this->GetById($id);
			$image = $project[0]['image'];
		}
		
		$object = array('image' => $image);
						
		foreach($this->keysArray as $val)
		{
			$object[$val] = mysql_real_escape_string(trim($_REQUEST[$val]));
		}
		
		$url_pattern = '/^(http|https):\/\//';
		
		if(!preg_match($url_pattern, $object['link']))
		{
			$object['link'] = 'http://' . $object['link'];
		}
		
		$url_pattern = '/^(http|https)://[a-zA-Z0-9]([a-zA-Z0-9-]*\.)+[a-zA-Z]{2,4}';
						
		return $object;
	}
	
	public function GetSpecialities()
	{
		$query = "SELECT * FROM speciality";
		return $this->msql->Select($query);
	}
}
?>