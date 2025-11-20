<!doctype html>
<html lang = "ru">
	<head>
		<?php
			use Proj\UI\Templates;

			/** @var Templates\Admin $template */ $template = template('admin');
		?>
		<meta charset = "UTF-8">
		<meta name = "viewport" content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv = "X-UA-Compatible" content = "ie=edge">
		<?php $template->browseHead(); ?>
	</head>
	<body>
		<header class = "section header"><?php $template->layout->header->browse(); ?></header>
		<div>
			<menu class = "section menu"><?php $template->layout->menu->browse(); ?></menu>
			<main class = "section content"><?php $template->layout->content->browse(); ?></main>
		</div>
		<footer class = "section footer"><?php $template->layout->footer->browse(); ?></footer>
		<script>
			$(function() {
				Base.GlobalParams.set('request', '<?= request()->html(); ?>');
				Base.GlobalParams.set('xhr', '<?= request()->xhr(); ?>');
				Base.Debugger.getInstance();
				getContent('<?= request()->html(); ?>');
				Base.History.Initialization();
			});
		</script>
	</body>
</html>