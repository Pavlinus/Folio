<?php
class ImageHandler
{
	const MAX_FILE_SIZE = 3072000;
	private $width = 150;
	
	private static $instance;
	
	
	public function Instance()
	{
		if(self::$instance == null)
		{
			self::$instance = new ImageHandler();
		}
		
		return self::$instance;
	}
	
	
	public function UploadImage($file, $userDir)
	{
		if($file['size'] > self::MAX_FILE_SIZE)
		{
			die("Размер изображения превышает позволенные значения");
		}
		
		$file_ext = $this->FileExt($file);
		
		if(!$file_ext)
		{
			die("Неверный формат изображения");
		}
		
		// Путь для хранения изображения и его миниатюры
		$path = "images/" . $userDir . "/";
		$orig = $path . $file['name']; 
		$thumb = $path . "thumb_" . $file['name'];
		
		if(!file_exists($path))
		{
			mkdir($path);
		}
		
		if(!copy($file['tmp_name'], $orig))
		{
			return false;
		}
		
		return array(
			'orig' => $orig, 
			'thumb' => $thumb,
			'ext' => $file_ext);
	}
	
	
	//
	// Сохраняет аватар пользователя и создает миниатюру
	//
	public function UploadUserImage($file, $userDir)
	{
		$upload = $this->UploadImage($file, $userDir);
		
		if(!isset($upload))
		{
			return false;
		}
		
		if(!$this->CreateThumbnail($upload['orig'], 
								   $upload['ext'], 
								   $upload['thumb']))
		{
			return false;
		}
		
		return array($upload['orig'], $upload['thumb']);
	}
	
	
	//
	// Создание миниатюры
	// $orig - путь к оригиналу
	// $file_ext - расширение изображения
	// $thumbnail - путь сохранения миниатюры
	//
	public function CreateThumbnail($orig, $file_ext, $thumbnail)
	{
		$info = getimagesize($orig);
		$orig_dimens = array($info[0], $info[1]);
		
		$koeff = $orig_dimens[0] / $this->width;
		$new_height = ceil($orig_dimens[1] / $koeff);
		
		$method = "imagecreatefrom" . $file_ext;
		$image_orig = $method($orig);
		
		$thumb = imagecreatetruecolor($this->width, $new_height);
		
		imagecopyresampled($thumb, $image_orig, 0, 0, 0, 0, 
			$this->width, $new_height, $orig_dimens[0], $orig_dimens[1]);
		
		$method = "image" . $file_ext;
		
		return $method($thumb, $thumbnail);
	}
	
	
	//
	// Определение расширения файла
	//
	private function FileExt($file)
	{
		switch($file['type'])
		{
			case "image/png":
				return "png";
			case "image/jpg":
			case "image/jpeg":
				return "jpeg";
			case "image/gif":
				return "gif";
			default:
				return false;
		}
	}
}
?>