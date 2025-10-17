<?php
	/**
	 * @var string $title
	 * @var array $items
	 */
?>
<div class = "view changes last">
	<div class = "grid col_1">
		<div>
			<h2><?= $title; ?></h2>
		</div>
	</div>
	<div class = "list">
		<?php foreach ($items as $item) { ?>
			<div class = "view changes item">
				<?= linkInternal('changes_show')->hyperlink($item['header'], ['id' => $item['id']]); ?>
			</div>
		<?php } ?>
	</div>
	<div class = "all"><?= linkInternal('changes')->hyperlink(__('Все изменения')); ?></div>
</div>