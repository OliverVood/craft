<!doctype html>
<html lang = "ru">
<head>
	<meta charset = "UTF-8">
	<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
	<?php \proj\ui\templates\site\Template::browseHead(); ?>
</head>
	<body>
		<header><?php \proj\ui\templates\site\Template::$layout->header->browse(); ?></header>
		<main><?php \proj\ui\templates\site\Template::$layout->main->browse(); ?></main>
		<footer><?php \proj\ui\templates\site\Template::$layout->footer->browse(); ?></footer>
	</body>
</html>