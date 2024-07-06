<!doctype html>
<html lang = "ru">
<head>
	<meta charset = "UTF-8">
	<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
	<?php \Proj\Templates\Auth\Template::browseHead(); ?>
</head>
	<body>
		<header><?php \Proj\Templates\Auth\Template::$layout->header->browse(); ?></header>
		<main><?php \Proj\Templates\Auth\Template::$layout->main->browse(); ?></main>
		<footer><?php \Proj\Templates\Auth\Template::$layout->footer->browse(); ?></footer>
		<script>
			$(function() {
				Base.GlobalParams.set('request', '<?= REQUEST; ?>');
				Base.GlobalParams.set('xhr', '<?= XHR; ?>');
			});
		</script>

	</body>
</html>