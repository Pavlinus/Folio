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
				<div id="optionButton">
					<a href="index.php?c=settings&act=style">Изменить стиль</a>
				</div>
				<div></div>
			</div>
		<? endif; ?>
		
		<div id="avatar" style="background: url(<?=$user['avatar_thumb']?>) no-repeat center center;">
		</div>
		
		<div id="userInfo">
			<h2><?=$user['f_name'] . " " . $user['l_name']?></h2>
			<div id="userInfoDetails">
				<div id="userDetailsLeft">
					<div id="userDetailsField">
						<img src="../images/location_50.png" />
						<p><?=$user['location']?></p>
					</div>
					<div id="userDetailsField">
						<img src="../images/skills_50.png" />
						<p><?=$user['skills']?></p>
					</div>
					<div id="userDetailsField">
						<img src="../images/education_50.png" />
						<p><?=$user['education']?></p>
					</div>
					<div id="userDetailsField">
						<img src="../images/mail_50.png" />
						<p><?=$user['email']?></p>
					</div>
					<div id="userDetailsField">
						<img src="../images/phone_50.png" />
						<p><?=$user['phone']?></p>
					</div>
				</div>
				<div id="userDetailsRight">
					<p><?=$user['about']?></p>
				</div>
				
			</div>
			<div id="social">
					<div id="socialInner">
						<? if($social['vk'] != '') : ?>
							<div id="socialItem">
								<a href="<?=$social['vk']?>">
									<img src="images/vk_stroke.png"/>
								</a>
							</div>
						<? endif; ?>
						<? if($social['facebook'] != '') : ?>
							<div id="socialItem">
								<a href="<?=$social['facebook']?>">
									<img src="images/facebook_enabled_120.png"/>
								</a>
							</div>
						<? endif; ?>
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
											<?=$project['link_cut']?>
										</a>
									</div>
									<p><?=$project['description']?></p>
								</div>
								<div id="projectAreaInnerRight">
									<img src="<?=$project['image']?>"/>
								</div>
							</div>
							<? 
								session_start();
								if(isset($_SESSION['sid']) && $_GET['id'] == $_COOKIE['user_id']) : 
							?>
								<div id="optionButton">
									<a href="index.php?c=project&act=edit&id=<?=$project['project_id']?>">Изменить</a>
								</div>
							<? endif; ?>
						<? endforeach; ?>
					<? else : ?>
						<p class="pageMessage">Здесь пока нет проектов</p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>