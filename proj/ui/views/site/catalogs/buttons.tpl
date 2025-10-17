<div class = "view catalogs buttons">
	<div class = "grid col_1">
		<div>
			<h1><?= __('Начните работу прямо сейчас'); ?></h1>
		</div>
	</div>
	<div class = "btns">
		<?= linkInternal('estimates')->hyperlink(__('Сметы') . ' »', [], ['class' => 'button']); ?>
		<?= linkInternal('certificates')->hyperlink(__('Акты выполненных работ') . ' »', [], ['class' => 'button']); ?>
		<?= linkInternal('price_lists')->hyperlink(__('Прайс-листы') . ' »', [], ['class' => 'button']); ?>
	</div>
</div>