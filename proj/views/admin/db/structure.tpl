<?php /** @var array $structure */ ?>
<div class = "view db structure">
	<h1><?= __('Структура базы данных') ?></h1>
	<div id = "structure"></div>
	<script>
		new Admin.DB.Structure(<?= json_encode($structure); ?>);
	</script>
</div>