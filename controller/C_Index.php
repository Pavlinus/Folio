<?php
class C_Index extends C_Base
{
	public function action_index()
	{		
		// Попытка авторизации, если были переданы данные
		if($this->isPost())
		{
			if(isset($_POST['login']) && isset($_POST['password']))
			{
				$mUser = M_User::Instance();
				$auth = $mUser->Login($_POST['login'], $_POST['password']);
				
				if(!$auth)
				{
					$error = true;
					$login = $_POST['login'];
					$err_msg = "Введен неверный логин или пароль";
				}
				else
				{
					header("Location: index.php?c=user&act=get");
				}
			}
		}
		
		$this->content = $this->Template('view/v_index.php', 
										 array(
											'error' => $error,
											'login' => $login,
											'err_msg' => $err_msg));
	}
}
?>