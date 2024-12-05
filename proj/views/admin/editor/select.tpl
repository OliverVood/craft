<?php
	/** @var string $title */
	/** @var Base\Editor\Fields $fields */
	/** @var Base\DB\Response $items */
	/** @var Base\Helper\Pagination|null $pagination */
	/** @var Base\Editor\Controller $editor */

	$paginationHTML = $pagination ? (string)$pagination : '';
?>
<div class = "view editor select">
	<div class = "navigate">
		<?php foreach ($editor->getLinksNavigateSelect()->each() as $link) echo $link; ?>
	</div>
	<h1><?= $title; ?></h1>
	<?= $paginationHTML; ?>
	<table class = "select">
		<thead>
		<tr>
			<?php
				foreach ($fields->each() as /** @var Base\Editor\Skins\Skin $field */$field) {
					?><th><?= $field->getTitle(); ?></th><?php
				}
				$count = $editor->getLinksManage([])->count();
				if ($count) {
					?><th colspan = "<?= $count; ?>"><?= __('Управление'); ?></th><?php
				}
			?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($items->each() as $item) { ?>
			<tr>
				<?php foreach ($fields->each() as /** @var Base\Editor\Skins\Skin $field */ $field) { ?>
					<td>
						<?= $field->format($item[$field->getName()]); ?>
					</td>
				<?php } ?>
				<?php
					if ($count) {
						foreach ($editor->getLinksManage($item)->each() as $link) {
							?><td><?= $link; ?></td><?php
						}
					} ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?= $paginationHTML; ?>
</div>