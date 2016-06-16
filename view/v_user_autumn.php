<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../styles/style_autumn.css">
</head>
<body>
	<div id="billboard">
		<header id="header">
			<div id="headerInner">
				<div id="logo">
					<a href="index.php"><h2>FOLIO</h2></a>
				</div>
				<nav id="topMenuRight">
					<ul>
						<li><a href="index.php?c=about">О ПРОЕКТЕ</a></li>
						<li><a href="#contacts">КОНТАКТЫ</a></li>
						<? 
							session_start();
							if(isset($_SESSION['sid'])) : ?>
								<li><a href="index.php?c=user&act=get&id=<?=$_COOKIE['user_id']?>">ПРОФИЛЬ</a></li>
								<li><a href="index.php?c=user&act=logout">ВЫЙТИ</a></li>
						<? endif; ?>
					</ul>
				</nav>
			</div>
		</header>
		
		<? 
			session_start();
			if(isset($_SESSION['sid']) && $_GET['id'] == $_COOKIE['user_id']) : 
		?>
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
		<div id="avatar" style="background: url(<?=$user['avatar_thumb']?>) no-repeat center center;"></div>
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
		<h1>Мои проекты</h1>
		<div id="projectAreaInner">
			<div id="itemsContainer">
			<? if(count($projects) > 0) : ?>
				<? foreach($projects as $project) : ?>
				<div id="projectItem">
					<img src="<?=$project['image']?>"/>
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
					<div id="avatar" style="background: url(<?=$user['avatar_thumb']?>) no-repeat center center;"></div>
					<div id="info">
						<h1>Павел Ковыршин</h1>
					</div>
				</div>
			</div>
			<div id="footerInnerRight">
				<div id="contacts_info">
					<div id="location">
						<img src="../images/style_1/location.png"/>
						<p><?=$user['location']?></p>
					</div>
					<div id="phone">
						<img src="../images/style_1/phone.png"/>
						<p><?=$user['phone']?></p>
					</div>
					<div id="email">
						<img src="../images/style_1/email.png"/>
						<p><?=$user['email']?></p>
					</div>
				</div>
				<div id="social_info">
					<? if($social['vk'] != '') : ?>
						<a href="<?=$social['vk']?>">
							<img src="../images/style_1/vk.png"/>
						</a>
					<? endif; ?>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>