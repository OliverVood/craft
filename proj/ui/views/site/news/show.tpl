<?php
	/**
	 * @var string $header
	 * @var string $content
	 * @var string $datepb
	 * @var string $cover
	 */

	$background = $cover ? 'style = "background-image: url(' . $cover . ');"' : '';
?>
<div class = "view news show">
	<div class = "cover"<?= $background; ?>>
		<div></div>
		<div class = "grid col_1">
			<div>
				<h1><?= $header; ?></h1>
			</div>
		</div>
	</div>
	<div class = "content"><?= $content; ?></div>
	<div class = "data publish"><?= $datepb; ?></div>
</div>