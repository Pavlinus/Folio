
		<div id="content">
			<div id="inputArea">
				<div id="inputAreaInner">
					<form method="post" enctype="multipart/form-data" class="basicInputField">
						<input type="text" name="name" placeholder="Название проекта" value="<?=$project['name']?>"/>
						<textarea placeholder="Описание" name="description"><?=$project['description']?></textarea>
						<input type="text" name="link" placeholder="Ссылка" value="<?=$project['link']?>"/>
						<input type="file" name="image"/>
						<input type="submit" class="submitButton" value="Сохранить"/>
					</form>
				</div>
			</div>
		</div>