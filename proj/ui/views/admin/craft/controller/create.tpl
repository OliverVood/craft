<div class = "view craft controller create">
	<h1><?= __('Создание контроллера'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'controller', 'action' => 'create']); ?>">
		<?php echo csrf(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Название контроллера'); ?>">
			<div class = "errors"></div></div>
		<div><label><input type = "checkbox" name = "flags[]" value = "-model"><?= __('Создать модель'); ?></label></div>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>