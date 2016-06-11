<div id="inputArea" class="registrationArea">
	<div id="inputAreaInner">
		<form method="post" enctype="multipart/form-data" class="basicInputField">
			<? if($error) : ?>
				<p class="input_error_msg"><?=$err_msg?></p>
			<? endif; ?>
			<input type="text" id="login" name="login" placeholder="Логин" value="<?=$_REQUEST['login']?>" required/>
			<input type="password" id="password" name="password" placeholder="Пароль" required/>
			<input type="text" id="f_name" name="f_name" placeholder="Имя" value="<?=$_REQUEST['f_name']?>" required/>
			<input type="text" id="l_name" name="l_name" placeholder="Фамилия" value="<?=$_REQUEST['l_name']?>" required/>
			<input type="text" id="email" name="email" placeholder="Email" 
				value="<?=$_REQUEST['email']?>" oninput="validateEmail(this)" required/>
			<input type="submit" class="submitButton" value="Сохранить"/>
		</form>
	</div>
</div>
<script src="../scripts/input.js" async></script>