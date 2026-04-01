<div class = "view craft feature create">
	<h1><?= __('Создание признака'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'feature', 'action' => 'create']); ?>">
		<?= csrfInput(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним признака'); ?>">
			<div class = "errors"></div>
		</div>
		<div class = "m-t-24">
			<?= componentSolution()->checkbox(__('Назначение прав'), ['name' => 'params[right][]', 'value' => 'access']); ?>
			<?= componentSolution()->checkbox(__('Выборка'), ['name' => 'params[right][]', 'value' => 'select', 'class' => 'm-t-8']); ?>
			<?= componentSolution()->checkbox(__('Вывод'), ['name' => 'params[right][]', 'value' => 'browse', 'class' => 'm-t-8']); ?>
			<?= componentSolution()->checkbox(__('Создание'), ['name' => 'params[right][]', 'value' => 'create', 'class' => 'm-t-8']); ?>
			<?= componentSolution()->checkbox(__('Изменение'), ['name' => 'params[right][]', 'value' => 'update', 'class' => 'm-t-8']); ?>
			<?= componentSolution()->checkbox(__('Удаление'), ['name' => 'params[right][]', 'value' => 'delete', 'class' => 'm-t-8']); ?>
			<?= componentSolution()->checkbox(__('Изменение состояния'), ['name' => 'params[right][]', 'value' => 'status', 'class' => 'm-t-8']); ?>
		</div>
		<div class = "m-t-24"><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>