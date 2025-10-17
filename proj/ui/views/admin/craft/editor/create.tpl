<div class = "view craft editor create">
	<h1><?= __('Создание редактора'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'editor', 'action' => 'create']); ?>">
		<?= csrfInput(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним редактора'); ?>">
			<div class = "errors"></div>
		</div>
		<div data-field = "feature"><input type = "text" name = "params[feature]" placeholder = "<?= __('Псевдоним признака'); ?>">
			<div class = "errors"></div>
		</div>
		<div data-field = "database"><input type = "text" name = "params[database]" placeholder = "<?= __('Псевдоним базы данных'); ?>">
			<div class = "errors"></div>
		</div>
		<div data-field = "table"><input type = "text" name = "params[table]" placeholder = "<?= __('Название таблицы'); ?>">
			<div class = "errors"></div>
		</div>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>