<?php
 /**
  * @var string $title
  * @var array $items
  */
?>
<div class = "view news all">
	<div class = "grid col_1">
		<div>
			<h2><?= $title; ?></h2>
		</div>
	</div>
	<div class = "list grid col_3">
		<?php foreach ($items as $item) {
			$background = $item['cover'] ? 'style = "background-image: url(' . $item['cover'] . ');"' : '';
		?>
			<div class = "view news item">
				<div class = "cover"<?= $background; ?>></div>
				<h3 class = "header"><?= $item['header']; ?></h3>
				<div class = "content"><?= $item['content']; ?></div>
				<div class = "links"><?= linkInternal('news_show')->hyperlink(__('Читать'), ['id' => $item['id']]); ?></div>
			</div>
		<?php } ?>
	</div>
</div>