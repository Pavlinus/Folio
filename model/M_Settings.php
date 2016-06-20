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
	
	public function StyleExists($id)
	{
		$query = "SELECT * FROM styles WHERE style_id = {$id}";	
		return $this->msql->Select($query);
	}
	
	public function GetStylesAll()
	{
		$query = "SELECT * FROM styles";
		return $this->msql->Select($query);
	}
	
	public function UseStyle($style_id)
	{
		$mUser = M_User::Instance();
		$setting = $mUser->GetSettingsId();
		
		$style = array('style_id' => $style_id);
		$where = "setting_id = " . $setting[0]['settings_id'];
		
		return $this->msql->Update('settings', $style, $where);
	}
	
	public function Add()
	{
		$settings = array('style_id' => 1);
		$this->msql->Insert('settings', $settings);
	}
}

?>