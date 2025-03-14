<?php
	/**
	 * @var string $user
	 * @var array $links
	 */
?>
<div class = "view out head">
	<div><?= __('Привет'); ?>, <?= $user; ?></div>
	<?= $links['logout']->hyperlinkXHR('', [], ['class' => 'ico logout']); ?>
</div>