<?

class C_Search extends C_Base 
{
	public function action_search()
	{
		$mSearch = M_Search::Instance();
		$projects = $mSearch->GetNew();
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
		
		$this->content = $this->Template('view/v_search.php', array('projects' => $projects));
	}
}

?>