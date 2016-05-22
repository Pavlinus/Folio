<?php
	
class C_User extends C_Base 
{
	//
	// Переход на главную страницу сайта
	// в зависимости от статуса авторизации
	//
	public function action_get()
	{
		session_start();
		
		// Пользователь не авторизован
		if(!isset($_SESSION['sid']))
		{
			header("Location: index.php");
			return;
		}
		
		$assoc = array();
		
		// Проекты пользователя
		$mProject = M_Project::Instance();
		$projects = $mProject->All($_COOKIE['user_id']);
		
		if($projects != null)
		{
			$assoc['projects'] = $projects;
		}
		else
		{
			$assoc['projects'] = array();
		}
		
		// Персональные данные пользователя
		$mUser = M_User::Instance();
		$user = $mUser->GetById($_COOKIE['user_id']);
		
		if($user[0] != null)
		{
			$assoc['user'] = $user[0];
		}
		else
		{
			//die("Не удалось получить данные о пользователе");
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
			
			if($result)
			{
				if($mUser->Login($_REQUEST['login'], $_REQUEST['password']))
				{
					header("Location: index.php?c=user&act=get");
				}
				else
				{
					die("Ошибка входа");
				}
			}
			else
			{
				$error = true;
				
				if($result == -1)
				{
					$err_msg = "Введенный логин занят";
				}
				else
				{
					$err_msg = "Ошибка соединения";
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
			$mUser->Update($_COOKIE['user_id']);
			header("Location: index.php?c=user&act=get");
		}
		
		$user = $mUser->GetById($_COOKIE['user_id']);
		$this->content = $this->Template('view/v_user_edit.php', array('user' => $user[0]));
	}
	
	
	//
	// Авторизация пользователя
	//
	public function action_login()
	{
		$arr = array();
		
		if($this->isPost())
		{
			$mUser = M_User::Instance();
			
			if(!$mUser->Login($_POST['login'], $_POST['password']))
			{
				$this->content = $this->Template('view/v_auth.php', 
											array(
												'login' => $_POST['login'],
												'error' => true));
				
				return false;
			}
			else
			{
				header("Location: index.php?c=user");
				//$this->action_index();
				
				return true;
			}
		}
		
		$this->content = $this->Template('view/v_auth.php', array());
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