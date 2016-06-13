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
	
	<div id="userboard">
		<div id="userboardInner">
			
		</div>
	<div>
	
	<footer>
		<div id="footerInner">
			<div id="socialInner">
				<div id="socialItem">
					<a href="http://vk.com/pavlinkov">
						<img id="contacts" src="images/vk_stroke.png"/>
					</a>
				</div>
			</div>
		</div>
		</div>
	</footer>
</body>
</html>