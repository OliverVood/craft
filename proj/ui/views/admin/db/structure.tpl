<?php /** @var array $structure */ ?>
<div class = "view dbs structure">
	<h1><?= __('Структура базы данных') ?></h1>
	<div></div>
	<script>
		new Admin.DB.Structure(<?= json_encode($structure); ?>);
	</script>
</div>