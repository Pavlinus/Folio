<?php
	
class C_User extends C_Base 
{
	const PROFILE_ID = 0;
	
	public function action_index()
	{
		if(!isset($_GET['profile_id']))
		{
			header("Location: index.php?c=profile");
		}
		
		$mProject = M_Project::Instance();
		$projects = $mProject->All(self::PROFILE_ID);
		
		if(!$projects)
		{
			$projects = array();
		}
		
		$this->content = $this->Template('view/v_profile.php', 
			array('projects' => $projects));
	}
	
	public function action_add()
	{
		if($this->isPost())
		{
			$mUser = M_User::Instance();
			$user_id = $mUser->Add();
			
			if($user_id)
			{
				setcookie('user_id', $user_id, time() + 3600);
				header("Location: index.php?c=profile");
				die();
			} 
			
			die("Не удалось добавить проект");
		}
		
		$this->content = $this->Template('view/v_add_profile.php', array());
	}
	
	public function action_login()
	{
		$mUser = M_User::Instance();
		$user = $mUser->Get();
			
		if($user)
		{
			setcookie('profile_id', $user['profile_id'], time() + 3600);
		}
		
		$this->content = $this->Template('view/v_profile.php', 
										 array('user' => $user));
	}
}

?>