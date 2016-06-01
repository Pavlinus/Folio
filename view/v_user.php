<div id="userboard">
	<div id="userboardInner">
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
				<div></div>
			</div>
		<? endif; ?>
		
		<div id="avatar">
			<img src="<?=$user['avatar_thumb']?>"/>
		</div>
		
		<div id="userInfo">
			<h2><?=$user['f_name'] . " " . $user['l_name']?></h2>
			<div id="userInfoDetails">
				<div id="userDetailsLeft">
					<p>Страна: <?=$user['location']?></p>
					<p>Навыки: <?=$user['skills']?></p>
					<p>Образование: <?=$user['education']?></p>
					<p>Email: <?=$user['email']?></p>
					<p>Номер телефона: <?=$user['phone']?></p>
				</div>
				<div id="userDetailsRight">
					<p><?=$user['about']?></p>
				</div>
				<div id="social">
					<div id="socialInner">
						<? if($social['vk'] != '#') : ?>
							<a href="<?=$social['vk']?>">
								<img src="images/vk_enabled_120.png"/>
							</a>
						<? endif; ?>
						<? if($social['facebook'] != '#') : ?>
							<a href="<?=$social['facebook']?>">
								<img src="images/facebook_120.png"/>
							</a>
						<? endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<section id="wrapper">
	<div id="middle">
		<div id="content">
			<div id="projectArea">
				<div id="projectAreaInner">					
					<? if(count($projects) > 0) : ?>
						<? foreach($projects as $project) : ?>
							<div id="projectContent">
								<div id="projectAreaInnerLeft">
									<h2><?=$project['name']?></h2>
									<div class="borderBottomOrange separatorLine"></div>
									<div id="projectLink">
										<a href="<?=$project['link']?>">
											<?=$project['link']?>
										</a>
									</div>
									<p><?=$project['description']?></p>
								</div>
								<div id="projectAreaInnerRight">
									<img src="<?=$project['image']?>"/>
								</div>
							</div>
							<div id="optionButton">
								<a href="index.php?c=project&act=edit&id=<?=$project['project_id']?>">Изменить</a>
							</div>
						<? endforeach; ?>
					<? else : ?>
						<p class="pageMessage">Здесь пока нет проектов</p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>