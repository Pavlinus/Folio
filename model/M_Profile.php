<?php

class M_User
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
			self::$instance = new M_User();
		}
		
		return self::$instance;
	}
	
	
	public function Add()
	{
		$profile = array( 
				'f_name' => mysql_real_escape_string($_POST['f_name']),
				'l_name' => mysql_real_escape_string($_POST['l_name']),
				'email' => mysql_real_escape_string($_POST['email']),
				'phone' => mysql_real_escape_string($_POST['phone']),
				'edu' => mysql_real_escape_string($_POST['edu']),
				'skills' => mysql_real_escape_string($_POST['skills']),
				'img' => mysql_real_escape_string($_POST['img']));
	
		$profile_id = $this->msql->Insert('profiles', $profile);
		
		$user = array(
				'profile_id' => $profile_id,
				'login' => mysql_real_escape_string($_POST['login']),
				'password' => mysql_real_escape_string($_POST['pasw']));
		
		return $this->msql->Insert('users', $user);
	}
	
	
	public function Get()
	{
		$query = "SELECT * FROM users WHERE 
					login = '{$_POST['login']}' AND
					password = '{$_POST['password']}'";
		$user = $this->msql->Select($query);
		
		// Если пользователь существует
		if(isset($user['profile_id']))
		{
			$profile_id = $user['profile_id'];
		}
		else
		{
			return false;
		}
		
		$query = "SELECT * FROM profiles WHERE profile_id = $profile_id";
		
		return $this->msql->Select($query);
	}
	
	
	public function Del()
	{
		$where = "project_id = $project_id";
		
		return $this->msql->Delete('projects', $where);
	}
}
?>