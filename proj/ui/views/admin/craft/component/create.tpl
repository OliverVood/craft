<div class = "view craft component create">
	<h1><?= __('Создание компонента'); ?></h1>
	<form action = "<?= linkRight('craft_run')->path(['entity' => 'component', 'action' => 'create']); ?>">
		<?php echo csrf(); ?>
		<div data-field = "name"><input type = "text" name = "name" placeholder = "<?= __('Псевдоним компонента'); ?>">
			<div class = "errors"></div>
		</div>
		<div><input type = "submit" value = "<?= __('Создать'); ?>" onclick = "<?= linkRight('craft_run')->click(); ?>"></div>
	</form>
</div>