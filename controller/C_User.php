<?php
	
class C_User extends C_Base 
{	
	private $msql;
	
	public function __construct()
	{
		$this->msql = M_MSQL::Instance();
	}
	
	//
	// Страница профиля
	//
	public function action_get()
	{		
		$assoc = array();
		
		if(isset($_GET['id']))
		{
			if(!is_numeric($_GET['id']))
			{
				$error = "Не удалось получить данные пользователя";
				$this->content = $this->Template('view/v_error.php', array('error' => $error));
				return;
			}
			
			$user_id = mysqli_real_escape_string($this->msql->GetConnectionLink(), trim($_GET['id']));
		}
		else
		{
			header("Location: index.php");
		}
		
		$assoc = $this->UserDataAssoc($user_id);
		
		if($assoc['user'] == null)
		{
			$error = "Не удалось получить данные пользователя";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return;
		}
		
		if($assoc['social'] == null)
		{
			$assoc['social'] = array(
									'vk' => '', 
									'facebook' => '');
		}
		
		$user = $assoc['user'];
		$mSettings = M_Settings::Instance();
		$style = $mSettings->GetStyleValue($user['settings_id']);
		
		$this->content = $this->Template('view/' . $style[0]['value'], $assoc);
		$this->css = $style[0]['css'];
	}
	
	
	public function UserDataAssoc($user_id)
	{
		$assoc = array();
		
		// Проекты
		$mProject = M_Project::Instance();
		$projects = $mProject->All($user_id);
		$assoc['projects'] = $projects;
		
		// Персональные данные
		$mUser = M_User::Instance();
		$user = $mUser->GetById($user_id);
		$assoc['user'] = $user[0];
		
		// Соц. сети
		$social = $mUser->GetSocial($user_id);
		$assoc['social'] = $social[0];
		
		if($assoc['projects'] == null)
		{
			$assoc['projects'] = array();
		}
		else
		{
			// Выводим ссылки на проекты без `http://`
			foreach($assoc['projects'] as &$project)
			{
				$pattern = '/^http(s)?:\/\//';
				$project['link_cut'] = preg_replace($pattern, '', $project['link']);
			}
		}
		
		return $assoc;
	}
	
	
	//
	// Добавление нового пользователя 
	//
	public function action_add()
	{
		$error = false;
		$err_msg = '';
		$form_data = array('login' => '',
					  'f_name' => '',
					  'l_name' => '',
					  'email' => '');
		
		if($this->isPost())
		{
			$mUser = M_User::Instance();
			$result = $mUser->Add();
			
			foreach($form_data as $key => $value)
			{
				$form_data[$key] = $_REQUEST[$key];
			}
			
			if($result == -1)
			{
				$error = true;
				$err_msg = "Введенный логин занят";
			}
			else
			{
				if($mUser->Login($_REQUEST['login'], $_REQUEST['password']))
				{
					header("Location: index.php?c=user&act=get&id=" . $mUser->GetUid());
				}
				else
				{
					$error = "Не удалось войти в профиль. Повторите попытку позже.";
					$this->content = $this->Template('view/v_error.php', array('error' => $error));
					return;
				}
			}
		}
		
		$this->content = $this->Template('view/v_user_add.php', 
										 array(
												'error' => $error,
												'err_msg' => $err_msg,
												'form_data' => $form_data));
	}
	
	
	//
	// Изменение данных пользователя 
	//
	public function action_edit()
	{
		$mUser = M_User::Instance();
		
		if($this->isPost())
		{
			$rows = $mUser->Update($_COOKIE['user_id']);
			
			if($rows == -1)
			{
				$error = "Не удалось обновить данные. Повторите попытку позже.";
				$this->content = $this->Template('view/v_error.php', array('error' => $error));
				return;
			}
			else
			{
				header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
				return;
			}
		}
		
		$user = $mUser->GetById($_COOKIE['user_id']);
		$social = $mUser->GetSocial($_COOKIE['user_id']);
		
		$this->content = $this->Template('view/v_user_edit.php', 
											array(
												'user' => $user[0],
												'social' => $social[0]));
	}
	
	
	//
	// Выход из учетной записи
	//
	public function action_logout()
	{
		$mUser = M_User::Instance();
		$mUser->Logout();
		header("Location: index.php");
	}
}

?>