<?php /** @var array $data */ ?>
<div class = "view db structure">
	<h1><?= __('Структура базы данных') ?></h1>
	<div id = "structure"></div>
	<script>
		new Admin.DB.Structure(<?= json_encode($data['structure']); ?>);
	</script>
</div>