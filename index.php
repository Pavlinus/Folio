<?php	
	function __autoload($classname)
	{
		// Если загружается класс контроллера
		if(substr($classname, 0, 2) == "C_")
		{
			include_once("controller/$classname.php");
		}
		else
		{
			include_once("model/$classname.php");
		}
	}
	
	$action = 'action_';
	$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

	switch ($_GET['c'])
	{
		case 'user':
			$controller = new C_User();
			break;
		case 'project':
			$controller = new C_Project();
			break;
		case 'settings':
			$controller = new C_Settings();
			break;
		case 'search':
			$controller = new C_Search();
			break;
		case 'about':
			$controller = new C_About();
			break;
		default:
			$controller = new C_Index();
	}
	
	header('Content-type: text/html; charset=utf-8');
	
	if($_GET['c'] == 'search' && $_GET['act'] == 'search')
	{
		$controller->RequestAjax($action);
	}
	else
	{
		$controller->Request($action);
	}
?>