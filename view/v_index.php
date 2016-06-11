<div id="billboard">
	<div id="billboardInner">
		<h1>FOLIO</h1>
		<h2>PLACE FOR YOUR PORTFOLIO</h2>
		<div class="separatorLine borderBottomWhite"></div>
		<p>Project description bla bla</p>
		
		<a href="index.php?c=search&act=search" class="whiteBorderButton">Смотреть проекты</a>
		
		<? 
			session_start();
			if(!isset($_SESSION['sid'])) : 
		?>
			<form method="post">
				<div id="signPanel">
					<div id="signPanelTop">
						<a href="index.php?c=user&act=add">Регистрация</a>
					</div>
					<div id="signPanelMiddle">
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