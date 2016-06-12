<?

class C_Search extends C_Base 
{
	public function action_get()
	{
		$mSearch = M_Search::Instance();
		$projects = $mSearch->GetNewProjects();
		$this->PrepareProjectList(&$projects);
		
		$mProject = M_Project::Instance();
		$spec = $mProject->GetSpecialities();
		
		$this->content = $this->Template('view/v_search.php', 
			array('projects' => $projects,
				  'specialities' => $spec));
	}
	
	public function action_search()
	{
		if(isset($_GET['type']))
		{
			$mSearch = M_Search::Instance();
			$projects = $mSearch->GetProjectsByType($_GET['type']);
			
			$this->PrepareProjectList(&$projects);
			
			$this->content = $this->Template('view/v_search_projects.php', array('projects' => $projects));
		}
	}
	
	private function PrepareProjectList($projects)
	{
		$mUser = M_User::Instance();
		
		foreach($projects as $key => $project)
		{
			$user = $mUser->GetById($project['user_id']);
			$project['user_name'] = $user[0]['f_name'] . ' ' . $user[0]['l_name'];
			
			// Выводим ссылку на проект без `http://`
			$pattern = '/^http(s)?:\/\//';
			$project['link_cut'] = preg_replace($pattern, '', $project['link']);
			
			$projects[$key] = $project;
		}
	}
}

?>