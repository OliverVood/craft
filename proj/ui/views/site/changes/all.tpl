<?php
	/**
	 * @var string $title
	 * @var array $items
	 */
?>
<div class = "view changes all">
	<div class = "grid col_1">
		<div>
			<h1><?= $title; ?></h1>
		</div>
	</div>
	<div class = "list">
		<?php foreach ($items as $item) { ?>
			<div class = "view changes item">
				<?= linkInternal('changes_show')->hyperlink($item['header'], ['id' => $item['id']]); ?>
			</div>
		<?php } ?>
	</div>
</div>