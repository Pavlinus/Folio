<section id="wrapper">
	<div id="middle">
		<div id="content">
			<div id="inputArea">
				<div id="inputAreaInner">
					<form method="post" enctype="multipart/form-data" class="basicInputField">
						<select name="speciality">
							<? foreach($specialities as $spec) : ?>
								<option value="<?=$spec['spec_id']?>"><?=$spec['name']?></option>
							<? endforeach; ?>
						</select>
						<input type="text" name="name" placeholder="Название проекта" required/>
						<textarea placeholder="Описание" name="description" required></textarea>
						<input type="text" name="link" placeholder="Ссылка"/>
						<input type="file" name="image"/>
						<input type="submit" class="submitButton" value="Добавить"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>