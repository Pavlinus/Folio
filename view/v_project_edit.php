
		<div id="content">
			<div id="inputArea">
				<div id="inputAreaInner">
					<form method="post" enctype="multipart/form-data" class="basicInputField">
						<select name="type">
							<? foreach($specialities as $spec) : ?>
								<? if($spec['spec_id'] == $project['speciality']) :?>
									<option value="<?=$spec['spec_id']?>" selected><?=$spec['name']?></option>
								<? else : ?>
									<option value="<?=$spec['spec_id']?>"><?=$spec['name']?></option>
								<? endif; ?>
							<? endforeach; ?>
						</select>
						<input type="text" name="name" placeholder="Название проекта" value="<?=$project['name']?>"/>
						<textarea placeholder="Описание" name="description"><?=$project['description']?></textarea>
						<input type="text" name="link" placeholder="Ссылка" value="<?=$project['link']?>"/>
						<div id="avatarUpdateContainer">
							<img src="<?=$project['image']?>"/>
							<input type="file" name="image"/>
						</div>
						<input type="submit" class="submitButton" value="Сохранить"/>
					</form>
				</div>
			</div>
		</div>