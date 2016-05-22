<?php
//
// Базовый класс контроллера
//
abstract class C_Controller 
{
	protected abstract function render();
	
	public function Request($action)
	{
		$this->$action();
		$this->render();
	}
	
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	protected function Template($fileName, $vars = array())
	{
		foreach ($vars as $k => $v)
		{
			$$k = $v;
		}

		ob_start();
		include "$fileName";
		return ob_get_clean();	
	}	
	
	public function __call($name, $params){
        die('Вызываемый `' . $name .'` метод не найден.');
	}
}

?>