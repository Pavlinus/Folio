<?php
class ImageHandler
{
	const MAX_FILE_SIZE = 3072000;
	private $width = 300;
	private $height  = 300;
	
	private static $instance;
	
	
	public function Instance()
	{
		if(self::$instance == null)
		{
			self::$instance = new ImageHandler();
		}
		
		return self::$instance;
	}
	
	
	public function UploadImage($file)
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
		
		$original = "images/" . $file['name'];
		$thumb = "images/thumb_" . $file['name'];
		
		if(!copy($file['tmp_name'], $original))
		{
			die("Не удалось сохранить изображение");
		}
		
		if(!$this->CreateThumbnail($original, $file_ext, $thumb))
		{
			die("Не удалось создать миниатюру");
		}
		
		return array($original, $thumb);
	}
	
	
	public function CreateThumbnail($orig, $file_ext, $filename)
	{
		$info = getimagesize($orig);
		$orig_dimens = array($info[0], $info[1]);
		
		$method = "imagecreatefrom" . $file_ext;
		$image_orig = $method($orig);
		
		$thumb = imagecreatetruecolor($this->width, $this->height);
		
		imagecopyresampled($thumb, $image_orig, 0, 0, 0, 0, 
			$this->width, $this->height, $orig_dimens[0], $orig_dimens[1]);
		
		$method = "image" . $file_ext;
		
		return $method($thumb, $filename);
	}
	
	
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