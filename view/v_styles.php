<div id="styles">
	<div id="stylesInner">
		<? foreach($styles as $style) : ?>
			<div id="styleContainer">
				<img src="../images/<?=$style['image']?>"/>
				<a href="index.php?c=settings&act=preview&id=<?=$style['style_id']?>" class="button" target="_blank">Просмотр</a>
				<a href="index.php?c=settings&act=use_style&id=<?=$style['style_id']?>" class="button">Применить</a>
			</div>
		<? endforeach; ?>
	</div>
</div>