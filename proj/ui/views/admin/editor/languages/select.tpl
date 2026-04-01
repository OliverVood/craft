<?php
	/** @var string $title */
	/** @var Base\Editor\Fields $fields */
	/** @var array $items */
	/** @var Base\Helper\Pagination|null $pagination */
	/** @var Base\Editor\Controller $editor */

	$linksManage = $editor->select->fnGetLinksManage;
	$paginationHTML = $pagination ? (string)$pagination : '';
	$fnGetLinksNavigate = $editor->select->fnGetLinksNavigate;

	$languageIds = array_column($items['languages'], 'id');
?>
<div class = "view editor select">
	<?php if (!$fnGetLinksNavigate()->isEmpty()) { ?>
		<div class = "navigate">
			<?php
				foreach ($fnGetLinksNavigate()->each() as $link) echo $link;
			?>
		</div>
	<?php } ?>
	<h1><?= $title; ?></h1>
	<?= $paginationHTML; ?>
	<table class = "select">
		<thead>
			<tr>
				<th rowspan = "2"><?= __('Context'); ?></th>
				<th rowspan = "2"><?= __('Name'); ?></th>
				<?php if ($items['languages']) { ?><th colspan = "<?= count($items['languages']); ?>"><?= __('Languages'); ?></th><?php } ?>
				<th rowspan = "2"><?= __('Use in PHP'); ?></th>
				<th rowspan = "2"><?= __('Use in JavaScript'); ?></th>
			</tr>
			<?php if ($items['languages']) { ?>
				<tr>
					<?php foreach ($items['languages'] as $language) { ?>
						<th><?= $language['code']; ?></th>
					<?php } ?>
				</tr>
			<?php } ?>
		</thead>
		<tbody>
			<?php foreach($items['translations'] as $translation) { ?>
				<tr>
					<td><?= $translation['context']; ?></td>
					<td><?= $translation['name']; ?></td>
					<?php if ($languageIds) { ?>
						<?php foreach ($languageIds as $languageId) { ?>
							<td><?= isset($translation['translates'][$languageId]) ? $translation['translates'][$languageId]['value'] : ''; ?></td>
						<?php } ?>
					<?php } ?>
					<td><?= $translation['uses']['php']; ?></td>
					<td><?= $translation['uses']['js']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?= $paginationHTML; ?>
</div>