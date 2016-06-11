<div id="searchBoard">
	<div id="searchBoardInner">
		<div id="searchFilter">
			<form method="post">
				<h3>Сфера деятельности:</h3>
				<select>
					<option value="IT">IT, программирование</option>
					<option value="Graphics">Графика, дизайн</option>
					<option value="Video">Видео, кино</option>
				</select>
				<input type="submit" class="button" value="Найти"/>
			</form>
		</div>
		<div id="searchResults">
			<div id="projectArea">
				<div id="projectAreaInner">					
					<? if(count($projects) > 0) : ?>
						<? foreach($projects as $project) : ?>
							<div id="projectContent">
								<div id="projectAreaInnerRight">
									<img src="<?=$project['image']?>"/>
								</div>
								<div id="projectAreaInnerLeft">
									<h2><?=$project['name']?></h2>
									<div class="borderBottomOrange separatorLine"></div>
									<div id="projectAuthor">
										<a href="index.php?c=user&act=get&id=<?=$project['user_id']?>">
											<?=$project['user_name']?>
										</a>
									</div>
									<div id="projectLink">
										<a href="<?=$project['link']?>">
											<?=$project['link_cut']?>
										</a>
									</div>
									<p><?=$project['description']?></p>
								</div>
							</div>
						<? endforeach; ?>
					<? else : ?>
						<p class="pageMessage">Здесь пока нет проектов</p>
					<? endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>