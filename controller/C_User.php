<?php
	
class C_User extends C_Base 
{
	//
	// Страница профиля
	//
	public function action_get()
	{
		session_start();
		
		$assoc = array();
		
		if(isset($_GET['id']))
		{
			$user_id = mysql_real_escape_string(trim($_GET['id']));
		}
		else
		{
			header("Location: index.php");
		}
		
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
		
		if($assoc['user'] == null)
		{
			$error = "Не удалось получить данные о пользователе";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return;
		}
		
		if($assoc['social'] == null)
		{
			$assoc['social'] = array(
									'vk' => '', 
									'facebook' => '');
		}
		
		$this->content = $this->Template('view/v_user.php', $assoc);
	}
	
	
	//
	// Добавление нового пользователя 
	//
	public function action_add()
	{
		if($this->isPost())
		{
			$mUser = M_User::Instance();
			$result = $mUser->Add();
			
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
					die("Ошибка входа");
				}
			}
		}
		
		$this->content = $this->Template('view/v_user_add.php', 
										 array(
												'error' => $error,
												'err_msg' => $err_msg));
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
				// TODO: не удалось обновить профиль
			}
			else
			{
				header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
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