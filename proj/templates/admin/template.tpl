<!doctype html>
<html lang = "ru">
	<head>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
		<?php \Proj\Templates\Admin\Template::browseHead(); ?>
	</head>
	<body>
		<header class = "section header"><?php \Proj\Templates\Admin\Template::$layout->header->browse(); ?></header>
		<div>
			<menu class = "section menu"><?php \Proj\Templates\Admin\Template::$layout->menu->browse(); ?></menu>
			<main class = "section content"><?php \Proj\Templates\Admin\Template::$layout->content->browse(); ?></main>
		</div>
		<footer class = "section footer"><?php \Proj\Templates\Admin\Template::$layout->footer->browse(); ?></footer>
		<script>
			$(function() {
				Base.GlobalParams.set('request', '<?= request()->html(); ?>');
				Base.GlobalParams.set('xhr', '<?= request()->xhr(); ?>');
				getContent('admin');
				Base.History.Initialization();
			});
		</script>
	</body>
</html>