<div id="errorPage">
	<div id="errorPageInner">
		<h1 class="error_head">
			OMG!
		</h1>
		<p class="error_msg"><?=$error?></p>
		<div id="error_nav">
			<a href="index.php">На главную</a>
			<? 
				session_start();
				if(isset($_SESSION['sid'])) : 
			?>
				<a href="index.php?c=user&act=get&id=<?=$_COOKIE['user_id']?>">Профиль</a>
			<? endif; ?>
		</div>
	</div>
</div>