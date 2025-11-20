<!doctype html>
<html lang = "ru">
	<head>
		<?php
			use Proj\UI\Templates;

			/** @var Templates\Error $template */ $template = template('error');
		?>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
		<?php $template->browseHead(); ?>
		<style>
			main { padding: 20px; border: 1px solid red; }
			h1 { margin: 0 0 20px; text-align: center; font-weight: normal; }
			h3 { margin: 0 0 10px; }
		</style>
	</head>
	<body>
		<main><?php $template->layout->main->browse(); ?></main>
	</body>
</html>