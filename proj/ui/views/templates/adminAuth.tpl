<!doctype html>
<html lang = "ru">
	<head>
		<?php
			use Proj\UI\Templates;

			/** @var Templates\Auth $template */ $template = template('auth');
		?>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
		<?php $template->browseHead(); ?>
	</head>
	<body>
		<header><?php $template->layout->header->browse(); ?></header>
		<main><?php $template->layout->main->browse(); ?></main>
		<footer><?php $template->layout->footer->browse(); ?></footer>
		<script>
			$(function() {
				Base.GlobalParams.set('request', '<?= request()->html(); ?>');
				Base.GlobalParams.set('xhr', '<?= request()->xhr(); ?>');
			});
		</script>
	</body>
</html>