<?php

class M_User
{
	private static $instance;
	
	private $msql;
	private $uid;
	private $sid;
	
	const USER_ROLE = 1;
	const MODER_ROLE = 2;
	const ADMIN_ROLE = 3;
	
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
	
	
	public function GetUid()
	{
		return $this->uid;
	}
	
	public function Add()
	{
		if(!$this->LoginIsAvailable())
		{
			return -1;
		}
		
		$user = $this->UsersDataArray();
		$this->msql->Insert('users', $user);
		
		$socials = $this->SocialsDataArray(mysql_insert_id());
		$this->msql->Insert('social', $socials);
	}
	
	
	//
	// Проверяет доступность логина
	//
	private function LoginIsAvailable()
	{
		$rows = $this->GetByLogin(trim($_REQUEST['login']));
		
		if(count($rows) > 0)
		{
			return false;
		}
		
		return true;
	}
	
	
	public function GetByLogin($login)
	{
		$query = "SELECT * FROM users WHERE 
					login = '{$login}'";	
		
		return $this->msql->Select($query);
	}
	
	
	public function GetById($id)
	{
		$query = "SELECT * FROM users WHERE 
					user_id = $id";
		
		return $this->msql->Select($query);
	}
	
	
	public function GetSocial($user_id)
	{
		$query = "SELECT * FROM social WHERE 
					user_id = $user_id";
		
		return $this->msql->Select($query);
	}
	
	
	public function Del($user_id)
	{
		$where = "user_id = $user_id";
		
		return $this->msql->Delete('users', $where);
	}
	
	
	public function Update($user_id)
	{
		$user = $this->UsersDataArray();
		$socials = $this->SocialsDataArray($user_id);
		$where = "user_id = $user_id";
		
		$this->msql->Update("users", $user, $where);
		$this->msql->Update("social", $socials, $where);
	}
	
	
	public function Login($login, $password)
	{
		$user = $this->GetByLogin($login);
		
		if($user == null || !$user)
		{
			return false;
		}
		
		if($user[0]['password'] != md5($password))
		{
			return false;
		}
		
		session_start();
		
		$this->uid = $user[0]['user_id'];
		$this->sid = $this->GenerateStr();
		$_SESSION['sid'] = $this->sid;
		setcookie('user_id', $this->uid, time() + 3600);
		
		return true;
	}
	
	
	public function Logout()
	{
		unset($_SESSION['sid']);
		setcookie('user_id', '', time() - 3600);
		$this->uid = null;
		$this->sid = null;
		
		session_destroy();
	}
	
	
	//
	// Генерация случайной последовательности
	// $length 		- ее длина
	// результат	- случайная строка
	//
	private function GenerateStr($length = 10) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;  

		while (strlen($code) < $length) 
            $code .= $chars[mt_rand(0, $clen)];

		return $code;
	}
	
	
	//
	// Создает массив данных о пользователе
	//
	private function UsersDataArray()
	{
		// Выбрано изображение
		if($_FILES['avatar']['name'] != "")
		{			
			$image_handler = ImageHandler::Instance();
			$images = $image_handler->UploadImage($_FILES['avatar']);
		}
		else
		{
			// Пользователь существует в базе
			if(isset($this->uid))
			{
				$user = $this->GetById($this->uid);
				$images = array($user['avatar'], $user['avatar_thumb']);
			}
			else
			{
				$images = array("../images/example.png", "../images/example.png");
			}
		}
			
		$user_data = array( 
				'f_name' => mysql_real_escape_string(trim($_REQUEST['f_name'])),
				'l_name' => mysql_real_escape_string(trim($_REQUEST['l_name'])),
				'email' => mysql_real_escape_string(trim($_REQUEST['email'])),
				'phone' => mysql_real_escape_string(trim($_REQUEST['phone'])),
				'education' => mysql_real_escape_string(trim($_REQUEST['education'])),
				'skills' => mysql_real_escape_string(trim($_REQUEST['skills'])),
				'about' => mysql_real_escape_string(trim($_REQUEST['about'])),
				'avatar' => mysql_real_escape_string($images[0]),
				'avatar_thumb' => mysql_real_escape_string($images[1]),
				'location' => mysql_real_escape_string(trim($_REQUEST['location'])),
				'role_id' => self::USER_ROLE);
		
		// Если новый пользователь
		if(isset($_REQUEST['login']) && isset($_REQUEST['password']))
		{
			$user_data['login'] = mysql_real_escape_string(trim($_REQUEST['login']));
			$user_data['password'] = mysql_real_escape_string(md5(trim($_REQUEST['password'])));
		}
		
		return $user_data;
	}
	
	
	//
	// Создает массив данных о пользователе
	//
	private function SocialsDataArray($user_id)
	{
		$socials = array();
		$socials['user_id'] = $user_id;
		$socials['vk'] = $this->GetSocialLink('vk', '.com');
		$socials['facebook'] = $this->GetSocialLink('facebook', '.com');
		
		return $socials;
	}
	
	
	//
	// Приводит ссылку на соц. сеть к единому виду `vk.com/profile_id`
	//
	private function GetSocialLink($social_name, $domain)
	{
		$social = $social_name . $domain . "/";
		
		if(isset($_REQUEST[$social_name]))
		{
			if($_REQUEST[$social_name] == '')
			{
				return '';
			}
				
			$pos = strpos(strtolower($_REQUEST[$social_name]), $social);
			
			// Если передан только ID профиля
			if($pos === false)
			{
				return 'http://' . $social . $_REQUEST[$social_name];
			}

			return 'http://' . substr($_REQUEST[$social_name], $pos);
		}
		else
		{
			return '';
		}
	}
}
?>