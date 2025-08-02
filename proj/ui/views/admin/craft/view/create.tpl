<div class = "view craft display create">
	<h1><?= __('Создание отображения'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'view', 'action' => 'create']); ?>">
		<?php echo csrf(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним отображения'); ?>">
			<div class = "errors"></div>
		</div>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>