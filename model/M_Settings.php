<?php

class M_Settings
{
	private static $instance;
	private $msql;
	private $keysArray = array('name', 
							   'description', 
							   'link',
							   'type');
	
	function __construct()
	{
		$this->msql = M_MSQL::Instance();
	}
	
	public function Instance()
	{
		if(self::$instance == null)
		{
			self::$instance = new M_Settings();
		}
		
		return self::$instance;
	}
	
	public function GetStyleValue($setting_id)
	{
		$query = "SELECT * FROM styles WHERE style_id IN ";
		$query .= "(SELECT style_id FROM settings WHERE setting_id = {$setting_id})";
		
		return $this->msql->Select($query);
	}
}

?>