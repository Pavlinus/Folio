<?php

class C_Settings extends C_Base
{
	public function action_get()
	{		
		$this->content = $this->Temaplate('view/v_settings.php', array());
	}
	
	public function action_style()
	{
		$mSettings = M_Settings::Instance();
		$styles = $mSettings->GetStylesAll();
		
		$this->content = $this->Template('view/v_styles.php', array('styles' => $styles));
	}
	
	public function action_preview()
	{
		$cUser = new C_User();
		$assoc = $cUser->UserDataAssoc($_COOKIE['user_id']);
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id']))
		{
			$error = "Неудалось отобразить страницу.";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return;
		}
		
		$mSettings = M_Settings::Instance();
		$style = $mSettings->StyleExists($_GET['id']);
		
		if($style[0] == null)
		{
			$error = "Заданный стиль страницы не найден.";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return;
		}
		
		$this->content = $this->Template('view/' . $style[0]['preview'], $assoc);
		$this->css = $style[0]['css'];
	}
	
	public function action_use_style()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id']))
		{
			$error = "Неудалось применить стиль.";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return;
		}
		
		$mSettings = M_Settings::Instance();
		$mSettings->UseStyle($_GET['id']);
		header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
	}
}

?>