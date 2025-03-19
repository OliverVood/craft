<?php /** @var array $data */ ?>
<?php /** @var string $action */ ?>
<div class = "view dbs check">
	<h1><?= __('Проверка базы данных') ?></h1>
	<div></div>
	<script>
		Admin.DB.Render.Check.init(<?= json_encode($data); ?>, '<?= $action; ?>');
	</script>
</div>