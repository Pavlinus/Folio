<?php

class M_User
{
	private static $instance;
	
	private $msql;
	private $connectionLink;
	private $uid;
	private $sid;
	private $keysArray = array('f_name', 
							   'l_name', 
							   'email', 
							   'phone', 
							   'education', 
							   'skills', 
							   'about', 
							   'location');
	
	const USER_ROLE = 1;
	const MODER_ROLE = 2;
	const ADMIN_ROLE = 3;
	
	function __construct()
	{
		$this->msql = M_MSQL::Instance();
		$this->connectionLink = $this->msql->GetConnectionLink();
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
	
	
	//
	// Добавление нового пользователя
	//
	public function Add()
	{
		if(!$this->LoginIsAvailable())
		{
			return -1;
		}
		
		if(isset($_FILES['avatar']) && $_FILES['avatar']['name'] != "")
		{			
			$image_handler = ImageHandler::Instance();
			$images = $image_handler->UploadUserImage($_FILES['image'], 
													  trim($_REQUEST['login']));
		}
		else
		{
			$images = array("../images/user_default.png", "../images/user_default.png");
		}
		
		// Добавляем новое поле настроек в БД
		$mSettings = M_Settings::Instance();
		$mSettings->Add();
		
		$user_data = array( 
				'avatar' => mysqli_real_escape_string($this->connectionLink, $images[0]),
				'avatar_thumb' => mysqli_real_escape_string($this->connectionLink, $images[1]),
				'role_id' => self::USER_ROLE,
				'settings_id' => mysqli_insert_id($this->connectionLink));
				
		foreach($this->keysArray as $val)
		{
			$user_data[$val] = mysqli_real_escape_string($this->connectionLink, trim($_REQUEST[$val]));
		}
		
		$user_data['login'] = mysqli_real_escape_string($this->connectionLink, trim($_REQUEST['login']));
		$user_data['password'] = mysqli_real_escape_string($this->connectionLink, (md5(trim($_REQUEST['password']))));
		$this->msql->Insert('users', $user_data);
		
		// Запись данных соц. сетей
		$socials = $this->SocialsDataArray(mysqli_insert_id($this->connectionLink));
		$this->msql->Insert('social', $socials);
	}
	
	
	//
	// Проверяет доступность логина
	//
	private function LoginIsAvailable()
	{
		$login = mysqli_real_escape_string($this->connectionLink, trim($_REQUEST['login']));
		$rows = $this->GetByLogin($login);
		
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
		$user = $this->UserDataArray();
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
		setcookie('user_id', $this->uid, time() + 3600 * 12);
		
		return true;
	}
	
	
	public function Logout()
	{
		unset($_SESSION['sid']);
		setcookie('user_id', '', time() - 3600 * 12);
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
	// Создает массив данных пользователя
	// $user_login - false, когда Update; хранит логин при Add
	//
	private function UserDataArray($user_login = false)
	{
		// Если происходит Update данных
		if(!$user_login)
		{
			if(isset($_COOKIE['user_id']))
			{
				$user = $this->GetById($_COOKIE['user_id']);
				$user_login = $user[0]['login'];
			}
		}
		
		// Выбрано изображение
		if($_FILES['avatar']['name'] != "")
		{	
			
			$image_handler = ImageHandler::Instance();
			$images = $image_handler->UploadUserImage($_FILES['avatar'], $user_login);
		}
		else
		{
			session_start();
			
			// Если пользователь существует в базе - аватар не меняем
			if(isset($_SESSION['sid']))
			{
				$images = array($user[0]['avatar'], $user[0]['avatar_thumb']);
			}
			else
			{
				$images = array("../images/example.png", "../images/example.png");
			}
		}
		
		$user_data = array( 
				'avatar' => mysqli_real_escape_string($this->connectionLink, $images[0]),
				'avatar_thumb' => mysqli_real_escape_string($this->connectionLink, $images[1]),
				'role_id' => self::USER_ROLE);
				
		foreach($this->keysArray as $val)
		{
			$user_data[$val] = mysqli_real_escape_string($this->connectionLink, trim($_REQUEST[$val]));
		}
		
		// Если новый пользователь
		if(isset($_REQUEST['login']) && isset($_REQUEST['password']))
		{
			$user_data['login'] = mysqli_real_escape_string($this->connectionLink, trim($_REQUEST['login']));
			$user_data['password'] = mysqli_real_escape_string($this->connectionLink, (md5(trim($_REQUEST['password']))));
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
	
	
	public function GetSettingsId()
	{
		$query = "SELECT settings_id FROM users WHERE user_id = " . $_COOKIE['user_id'];
		return $this->msql->Select($query);
	}
}
?>