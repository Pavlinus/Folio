<form method="post" enctype="multipart/form-data" class="basicInputField">
	<div id="inputArea">
		<div id="inputAreaInner">
			<input type="text" name="f_name" value="<?=$user['f_name']?>" placeholder="Имя"/>
			<input type="text" name="l_name" value="<?=$user['l_name']?>" placeholder="Фамилия"/>
			<input type="text" name="location" value="<?=$user['location']?>" placeholder="Страна"/>
			<input type="text" name="skills" value="<?=$user['skills']?>" placeholder="Навыки"/>
			<input type="text" name="education" value="<?=$user['education']?>" placeholder="Образование"/>
			<input type="text" name="email" value="<?=$user['email']?>" placeholder="Email"/>
			<input type="text" name="phone" value="<?=$user['phone']?>" placeholder="Номер телефона"/>
			<textarea placeholder="О себе" name="about"><?=$user['about']?></textarea>
			<input type="text" name="vk" value="<?=$social['vk']?>" placeholder="Профиль в VKontakte"/>
			<input type="text" name="facebook" value="<?=$social['facebook']?>" placeholder="Профиль в Facebook"/>
			<div id="avatarUpdateContainer">
				<img src="images/example.png"/>
				<input type="file" name="avatar"/>
			</div>
			<input type="submit" class="submitButton" value="Сохранить"/>
		</div>
	</div>
</form>
