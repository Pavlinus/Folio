<div id="searchBoard">
	<div id="searchBoardInner">
		<div id="searchFilter">
			<form method="get">
				<h3>Сфера деятельности:</h3>
				<select id="projectType">
					<? foreach($specialities as $spec) : ?>
						<option value="<?=$spec['spec_id']?>"><?=$spec['name']?></option>
					<? endforeach; ?>
				</select>
				<input type="button" class="button" value="Найти" id="searchBtn"/>
			</form>
		</div>
		<div id="searchResults">
			<div id="projectArea">
				<div id="projectAreaInner">					
					<? if(count($projects) > 0) : ?>
						<? foreach($projects as $project) : ?>
							<div id="projectContent">
								<div id="projectAreaInnerRight">
									<div id="projectImage" class="no-margin" style="background-image: url(<?=$project['image']?>);"></div>
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

<script src="../scripts/search.js" async></script>