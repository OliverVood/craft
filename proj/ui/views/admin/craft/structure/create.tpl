<div class = "view craft structure create">
	<h1><?= __('Создание структуры'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'structure', 'action' => 'create']); ?>">
		<?php echo csrf(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним структуры'); ?>">
			<div class = "errors"></div>
		</div>
		<div data-field = "database"><input type = "text" name = "params[database]" placeholder = "<?= __('Псевдоним базы данных'); ?>">
			<div class = "errors"></div>
		</div>
		<div>
			<div class = "items"></div>
			<a onclick = "Base.Craft.Structure.addTable(this);">+ <?= __('Добавить таблицу'); ?></a>
		</div>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>