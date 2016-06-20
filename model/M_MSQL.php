<?php
//
// Помощник работы с БД
//
class M_MSQL
{
	private static $instance;
	private $connLink;
	
	public static function Instance()
	{	
		if (self::$instance == null)
		{
			self::$instance = new M_MSQL();
		}
		
		return self::$instance;
	}
	
	private function __construct()
	{
		// здесь подключение к базе
		$this->connect_db();
	}
	
	//
	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	//
	public function Select($query)
	{
		$result = mysqli_query($this->connLink, $query);
		
		if (!$result)
			die(mysql_error());
		
		$n = mysqli_num_rows($result);
		$arr = array();
	
		for($i = 0; $i < $n; $i++)
		{
			$row = mysqli_fetch_assoc($result);		
			$arr[] = $row;
		}

		return $arr;				
	}
	
	//
	// Вставка строки
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// результат	- идентификатор новой строки
	//
	public function Insert($table, $object)
	{			
		$columns = array(); 
		$values = array(); 
	
		foreach ($object as $key => $value)
		{
			$key = mysqli_real_escape_string($this->connLink, $key . '');
			$columns[] = $key;
			
			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else
			{
				$value = mysqli_real_escape_string($this->connLink, $value . '');
				$values[] = "'$value'";
			}
		}
		
		$columns_s = implode(',', $columns); 
		$values_s = implode(',', $values);  
			
		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysqli_query($this->connLink, $query);
								
		if (!$result)
			die(mysqli_error($this->connLink));
			
		return mysqli_insert_id($this->connLink);
	}
	
	//
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	//	
	public function Update($table, $object, $where)
	{
		$sets = array();
	
		foreach ($object as $key => $value)
		{
			$key = mysqli_real_escape_string($this->connLink, $key . '');
			
			if ($value === null)
			{
				$sets[] = "$value=NULL";			
			}
			else
			{
				$value = mysqli_real_escape_string($this->connLink, $value . '');					
				$sets[] = "$key='$value'";			
			}			
		}

		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = mysqli_query($this->connLink, $query);
		
		if (!$result)
			die(mysqli_error($this->connLink));

		return mysqli_affected_rows($this->connLink);	
	}
	
	//
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)	
	// результат	- число удаленных строк
	//		
	public function Delete($table, $where)
	{
		$query = "DELETE FROM $table WHERE $where";		
		$result = mysqli_query($this->connLink, $query);
						
		if (!$result)
			die(mysqli_error($this->connLink));

		return mysqli_affected_rows($this->connLink);
	}
	
	private function connect_db() 
	{
		// Настройки подключения к БД.
		$hostname = 'localhost'; 
		$username = 'zyqjkokx_pavlin'; 
		$password = '3S3o5Y9h';
		$dbName = 'zyqjkokx_creata';
	
		// Языковая настройка.
		setlocale(LC_ALL, 'ru_RU.UTF-8'); // Устанавливаем нужную локаль (для дат, денег, запятых и пр.)
		mb_internal_encoding('UTF-8'); // Устанавливаем кодировку строк
	
		// Подключение к БД.
		$this->connLink = mysqli_connect($hostname, $username, $password) or die('Проблемы с подключением к базе данных'); 
		mysqli_query($this->connLink, 'SET NAMES utf8');
		mysqli_select_db($this->connLink, $dbName) or die('Базы данных не существует');
	}
	
	public function GetConnectionLink()
	{
		return $this->connLink;
	}
}
