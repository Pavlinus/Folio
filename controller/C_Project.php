<?php
	
class C_Project extends C_Base 
{
	public function action_add()
	{		
		if($this->isPost())
		{
			$mProject = M_Project::Instance();
			$mProject->Add();
			
			header("Location: index.php?c=user&act=get");
			die();
		}
		
		$this->content = $this->Template("view/v_project_add.php", array());
	}
	
	
	public function action_get()
	{
		$project = null;
		
		if($this->isGet())
		{
			if(isset($_GET['id']))
			{
				$mProject = M_Project::Instance();
				$project = $mProject->Get($_GET['id']);
			}
		}
		
		if($project != null)
		{
			$this->content = $this->Template("view/v_project.php", 
				array('project' => $project[0]));
		}
		else
		{
			// TODO: если передан плохой id
		}
	}
	
	
	public function action_del()
	{
		if($this->isGet())
		{
			if(isset($_GET['id']))
			{
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
			if($this->isPost())
			{
				$project = $mProject->Update($_REQUEST['id']);
				
				if($project == -1)
				{
					die("Не удалось обновить проект с ID: " . $_REQUEST['id']);
				}
				
				header("Location: index.php?c=user&act=get&id=" . $_COOKIE['user_id']);
				return;
			}
			
			$project = $mProject->Get($_REQUEST['id']);
		}
		else
		{
			die("Проект не существует");
		}
		
		$this->content = $this->Template("view/v_project_edit.php", 
			array('project' => $project[0]));
	}
}

?>