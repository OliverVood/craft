<?php
	/**
	 * @var string $header
	 * @var array $content
	 * @var string $datepb
	 * @var string $cover
	 */
?>
<div class = "view changes show">
	<div class = "grid col_1">
		<div>
			<h1><?= $header; ?></h1>
		</div>
	</div>
	<div class = "list">
		<?php foreach ($content as $item) {
			$background = $item['cover'] ? 'style = "background-image: url(' . $item['cover'] . ');"' : '';
		?>
			<div class = "view change item">
				<div class = "cover"<?= $background; ?>></div>
				<div class = "wrap">
					<div class = "header"><?= $item['header']; ?></div>
					<div class = "content"><?= $item['content']; ?></div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class = "data publish"><?= $datepb; ?></div>
</div>