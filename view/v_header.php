<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>
<body>
	<header id="header">
		<div id="headerInner">
			<div id="logo">
				<h2>FOLIO</h2>
			</div>
			<nav id="topMenuRight">
				<ul>
					<li><a href="#">О ПРОЕКТЕ</a></li>
					<li><a href="#">КОНТАКТЫ</a></li>
					<? 
						session_start();
						if(isset($_SESSION['sid'])) : ?>
							<li><a href="index.php?c=user&act=get">ПРОФИЛЬ</a></li>
							<li><a href="index.php?c=user&act=logout">ВЫЙТИ</a></li>
					<? endif; ?>
				</ul>
			</nav>
		</div>
	</header>	