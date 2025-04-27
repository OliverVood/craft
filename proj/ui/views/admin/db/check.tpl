<?php /** @var array $data */ ?>
<?php /** @var string $action */ ?>
<?php /** @var string $csrf */ ?>
<div class = "view dbs check">
	<h1><?= __('Проверка базы данных') ?></h1>
	<div></div>
	<script>
		Admin.DB.Render.Check.init(<?= json_encode($data); ?>, '<?= $action; ?>', '<?= $csrf; ?>');
	</script>
</div>