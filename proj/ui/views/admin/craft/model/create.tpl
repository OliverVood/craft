<div class = "view craft model create">
	<h1><?= __('Создание модели'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'model', 'action' => 'create']); ?>">
		<?= csrfInput(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним модели'); ?>">
			<div class = "errors"></div>
		</div>
		<?= componentSolution()->checkbox(__('Использовать базу данных'), ['name' => 'params[model]', 'value' => '', 'onchange' => /** @lang JavaScript */ "globalThis.Craft.Controller.addDatabaseForModel(this);"]); ?>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>