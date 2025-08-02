<div class = "view craft controller create">
	<h1><?= __('Создание контроллера'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'controller', 'action' => 'create']); ?>">
		<?php echo csrf(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Название контроллера'); ?>">
			<div class = "errors"></div></div>
		<?= componentSolution()->checkbox(__('Создать модель'), ['name' => 'flags[]', 'value' => '-model']); ?>
		<div>
			<?= componentSolution()->checkbox(__('Использовать базу данных'), ['name' => 'flags[]', 'value' => '-database', 'onchange' => /** @lang JavaScript */ "console.log(this);"]); ?>
			<div><label><input type = "text" name = "params[-database]" placeholder = "<?= __('База данных'); ?>"></label></div>
		</div>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>