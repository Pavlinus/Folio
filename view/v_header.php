<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>
<title>CREATA</title>
<body>
	<header id="header">
		<div id="headerInner">
			<div id="logo">
				<a href="index.php"><h2>CREATA</h2></a>
			</div>
			<nav id="topMenuRight">
				<ul>
					<li><a href="index.php?c=about">О ПРОЕКТЕ</a></li>
					<li><a href="#contacts">КОНТАКТЫ</a></li>
					<? 
						if(session_status() !== PHP_SESSION_ACTIVE )
						{
							session_start();
						}
						
						if(isset($_COOKIE['user_id'])) : ?>
							<li><a href="index.php?c=user&act=get&id=<?=$_COOKIE['user_id']?>">ПРОФИЛЬ</a></li>
							<li><a href="index.php?c=user&act=logout">ВЫЙТИ</a></li>
					<? endif; ?>
				</ul>
			</nav>
		</div>
	</header>	