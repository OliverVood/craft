<div class = "view craft controller create">
	<h1><?= __('Создание контроллера'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'controller', 'action' => 'create']); ?>">
		<?= csrfInput(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним контроллера'); ?>">
			<div class = "errors"></div>
		</div>
		<?= componentSolution()->checkbox(__('Создать модель'), ['name' => 'params[model]', 'value' => '', 'onchange' => /** @lang JavaScript */ "globalThis.Craft.Controller.addModel(this);"]); ?>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>