<?php /** @var array $data */ ?>
<div class = "view db structure">
	<h1><?= __('Структура базы данных') ?></h1>
	<div id = "structure"></div>
	<script>
		console.log('asdjsgd')//TODO продолжить отсюда, не отрабатывает скрипт
		new Admin.General.Structure(<?= json_encode($data); ?>);
	</script>
</div>