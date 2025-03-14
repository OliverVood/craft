<!doctype html>
<html lang = "ru">
	<head>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
		<?php template('auth.template')->browseHead(); ?>
	</head>
	<body>
		<header><?php template('auth.template')->layout->header->browse(); ?></header>
		<main><?php template('auth.template')->layout->main->browse(); ?></main>
		<footer><?php template('auth.template')->layout->footer->browse(); ?></footer>
		<script>
			$(function() {
				Base.GlobalParams.set('request', '<?= request()->html(); ?>');
				Base.GlobalParams.set('xhr', '<?= request()->xhr(); ?>');
			});
		</script>
	</body>
</html>