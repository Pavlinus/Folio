<?php
//
// Базовый контроллер сайта.
//
abstract class C_Base extends C_Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
	protected $css;
	
	public function render()
	{
		if($this->css == 'style.css')
		{
			$page = $this->Template('view/v_header.php', array());
			$page .= $this->content;
			$page .= $this->Template('view/v_footer.php', array());
		}
		else
		{
			$page .= $this->content;
		}
		
		echo $page;
	}

	public function renderContent()
	{
		echo $this->content;
	}
}
?>