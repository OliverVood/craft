<?php /** @var array $data */ ?>
<?php /** @var string $action */ ?>
<div class = "view db check">
	<h1><?= __('Проверка базы данных') ?></h1>
	<script>
		Admin.DB.Render.Check.init(<?= json_encode($data); ?>, '<?= $action; ?>');
	</script>
</div>