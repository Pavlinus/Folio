<div id="billboard">
	<div id="billboardInner">
		<h1>CREATA</h1>
		<h2>ТВОЕ ПОРТФОЛИО</h2>
		<div class="separatorLine borderBottomWhite"></div>
		<p>Расскажи о себе и своих достижениях</p>
		
		<a href="index.php?c=search&act=get" class="whiteBorderButton">Смотреть проекты</a>
		
		<? 
			if (session_status() !== PHP_SESSION_ACTIVE ) 
			{ 
				session_start(); 
			}
			
			if(!isset($_COOKIE['user_id'])) : 
		?>
			<form method="post">
				<div id="signPanel">
					<div id="signPanelTop">
						<a href="index.php?c=user&act=add">Регистрация</a>
					</div>
					<div id="signPanelMiddle">
						<p><?=$err_msg?></p>
						<div id="signPanelField">
							<input class="signPanelInputText" type="text" name="login" placeholder="Логин"/>
						</div>
						<div id="signPanelField">
							<input class="signPanelInputText" type="password" name="password" placeholder="Пароль"/>
						</div>
					</div>
					<input type="submit" value="Войти" class="submitButton signPanelSubmit"/>
				</div>
			</form>
		<? endif; ?>
	</div>
</div>