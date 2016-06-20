<?
	if (session_status() !== PHP_SESSION_ACTIVE) 
	{ 
		session_start(); 
	}
	
	if(!isset($_COOKIE['user_id']))
	{
		$controlEnabled = false;
	}
	else
	{
		$controlEnabled = $_GET['id'] == $_COOKIE['user_id'] ? true : false;
	}
?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../styles/style_autumn.css">
</head>
<title>CREATA</title>
<body>
	<div id="billboard">
		<header id="header">
			<div id="headerInner">
				<div id="logo">
					<a href="index.php"><h2>CREATA</h2></a>
				</div>
				<nav id="topMenuRight">
					<ul>
						<li><a href="index.php?c=about">О ПРОЕКТЕ</a></li>
						<li><a href="#contacts">КОНТАКТЫ</a></li>
						<? if($controlEnabled) : ?>
								<li><a href="index.php?c=user&act=get&id=<?=$_COOKIE['user_id']?>">ПРОФИЛЬ</a></li>
								<li><a href="index.php?c=user&act=logout">ВЫЙТИ</a></li>
						<? endif; ?>
					</ul>
				</nav>
			</div>
		</header>
		
		<? if($controlEnabled) : ?>
			<div id="controlPanel">
				<div id="optionButton">
					<a href="index.php?c=user&act=edit">Редактировать</a>
				</div>
				<div id="optionButton">
					<a href="index.php?c=project&act=add">Добавить проект</a>
				</div>
				<div id="optionButton">
					<a href="index.php?c=settings&act=style">Изменить стиль</a>
				</div>
				<div></div>
			</div>
		<? endif; ?>
		<div id="avatar" style="background-image: url(<?=$user['avatar_thumb']?>);"></div>
		<h1><?=$user['f_name'] . " " . $user['l_name']?></h1>
	</div>
	
	<div id="details">
		<div id="detailsInner">
			<div id="detailsLeft">
				<h1><span class="l_yellow">01.</span> О себе</h1>
				<p><?=$user['about']?></p>
			</div>
			<div id="detailsRight">
				<h1><span class="l_blue">02.</span> Навыки</h1>
				<p><?=$user['skills']?></p>
			</div>
			<div id="detailsLeft">
				<h1><span class="l_green">03.</span> Образование</h1>
				<p><?=$user['education']?></p>
			</div>
		</div>
	</div>
	
	<div id="projectArea">
		<div id="gray_triangle"></div>
		<div id="projectAreaInner">
			<div id="itemsContainer">
			<? if(count($projects) > 0) : ?>
				<? foreach($projects as $project) : ?>
				<div id="projectItem">
					<div id="projectImage" style="background-image: url(<?=$project['image']?>);"></div>
					<a href="<?=$project['link']?>" target="_blank"><h3><?=$project['name']?></h3></a>
					<p><?=$project['description']?></p>
					
					<? if($controlEnabled) : ?>
						<div id="optionButton">
							<a href="index.php?c=project&act=edit&id=<?=$project['project_id']?>">Изменить</a>
							<a href="index.php?c=project&act=delete&id=<?=$project['project_id']?>">Удалить</a>
						</div>
					<? endif; ?>
					
				</div>
				<? endforeach; ?>
			<? else : ?>
				<p class="pageMessage">Здесь пока нет проектов</p>
			<? endif; ?>
			</div>
		</div>
	</div>
	
	<footer>
		<div id="footerInner">
			<div id="footerInnerLeft">
				<div id="name_image">
					<div id="avatar" style="background-image: url(<?=$user['avatar_thumb']?>);"></div>
					<div id="info">
						<h1>Павел Ковыршин</h1>
					</div>
				</div>
			</div>
			<div id="footerInnerRight">
				<div id="contacts_info">
					<div id="location">
						<img src="../images/style_autumn/location.png"/>
						<p><?=$user['location']?></p>
					</div>
					<div id="phone">
						<img src="../images/style_autumn/phone.png"/>
						<p><?=$user['phone']?></p>
					</div>
					<div id="email">
						<img src="../images/style_autumn/email.png"/>
						<p><?=$user['email']?></p>
					</div>
				</div>
				<div id="contacts">
					<div id="social_info">
						<? if($social['vk'] != '') : ?>
							<a href="<?=$social['vk']?>">
								<img src="../images/style_autumn/vk.png"/>
							</a>
						<? endif; ?>
						<? if($social['facebook'] != '') : ?>
							<a href="<?=$social['facebook']?>">
								<img src="../images/style_autumn/fb.png"/>
							</a>
						<? endif; ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>