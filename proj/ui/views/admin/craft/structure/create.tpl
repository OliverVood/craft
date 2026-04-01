<div class = "view craft structure create">
	<h1><?= __('Создание структуры'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'structure', 'action' => 'create']); ?>">
		<?= csrfInput(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним структуры'); ?>">
			<div class = "errors"></div>
		</div>
		<div data-field = "database"><input type = "text" name = "params[database]" placeholder = "<?= __('Псевдоним базы данных'); ?>" class = "m-t-8">
			<div class = "errors"></div>
		</div>
		<div class = "m-t-8">
			<div class = "items"></div>
			<div class = "m-t-8">
				<a onclick = "globalThis.Craft.Structure.addTable(this);" class = "btn">+ <?= __('Добавить таблицу'); ?></a>
			</div>
		</div>
		<div class = "m-t-24"><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>