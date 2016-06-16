<?php
	
class C_Project extends C_Base 
{
	public function action_add()
	{		
		if($this->isPost())
		{
			$mProject = M_Project::Instance();
			$mProject->Add();
			
			header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
			return;
		}
		
		$mProject = M_Project::Instance();
		$spec = $mProject->GetSpecialities();
		
		$this->content = $this->Template("view/v_project_add.php", array('specialities' => $spec));
		$this->css = 'style.css';
	}
	
	
	public function action_get()
	{
		$project = null;
		
		if($this->isGet())
		{
			if(isset($_GET['id']))
			{
				if(!is_numeric($_GET['id']))
				{
					$error = "Не удалось получить данные проекта";
					$this->content = $this->Template('view/v_error.php', array('error' => $error));
					return;
				}
			
				$mProject = M_Project::Instance();
				$project = $mProject->Get($_GET['id']);
			}
		}
		
		if($project != null && mysql_num_rows($project) > 0)
		{
			$this->content = $this->Template("view/v_project.php", 
				array('project' => $project[0]));
		}
		else
		{
			$error = "Не удалось получить данные о проекте";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
		}
	}
	
	
	public function action_del()
	{
		if($this->isGet())
		{
			if(isset($_GET['id']))
			{
				if(!$this->IsValidId())
				{
					return;
				}
				
				$mProject = M_Project::Instance();
				$project = $mProject->Del($_GET['id']);
			}
		}
		
		header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
	}
	
	
	public function action_edit()
	{
		$mProject = M_Project::Instance();
		
		if(isset($_REQUEST['id']))
		{
			if(!$this->IsValidId())
			{
				return;
			}
			
			if($this->isPost())
			{
				$project = $mProject->Update($_REQUEST['id']);
				
				if($project == -1)
				{
					$error = "Не удалось обновить данные проекта.";
					$this->content = $this->Template('view/v_error.php', array('error' => $error));
				}
				
				header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
				return;
			}
			
			$project = $mProject->Get($_REQUEST['id']);
			
			if($project == null || count($project) == 0)
			{
				$error = "Не удалось получить данные о проекте.";
				$this->content = $this->Template('view/v_error.php', array('error' => $error));
				return;
			}
		}
		else
		{
			$error = "Не удалось получить данные о проекте.";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return;
		}
		
		$spec = $mProject->GetSpecialities();
		
		$this->content = $this->Template("view/v_project_edit.php", 
			array('project' => $project[0],
				  'specialities' => $spec));
		$this->css = 'style.css';
	}
	
	private function IsValidId()
	{
		if(!is_numeric($_GET['id']))
		{
			$error = "Не удалось получить данные проекта";
			$this->content = $this->Template('view/v_error.php', array('error' => $error));
			return false;
		}
		
		return true;
	}
}

?>