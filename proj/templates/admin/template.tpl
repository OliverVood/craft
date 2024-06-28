<!doctype html>
<html lang = "ru">
<head>
	<meta charset = "UTF-8">
	<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
	<?php \Proj\Templates\Admin\Template::browseHead(); ?>
</head>
	<body>
		<header><?php \Proj\Templates\Admin\Template::$layout->header->browse(); ?></header>
		<main>
			<div><?php \Proj\Templates\Admin\Template::$layout->menu->browse(); ?></div>
			<div><?php \Proj\Templates\Admin\Template::$layout->content->browse(); ?></div>
		</main>
		<footer><?php \Proj\Templates\Admin\Template::$layout->footer->browse(); ?></footer>
	</body>
</html>