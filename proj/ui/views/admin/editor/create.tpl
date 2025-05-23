<?php
	/** @var string $title */
	/** @var Base\Editor\Fields $fields */
	/** @var array $item */
	/** @var Base\Link\Right $action */
	/** @var string $textBtn */
	/** @var Base\Editor\Controller $editor */
?>
<div class = "view editor create">
	<div class = "navigate">
		<?php foreach ($editor->create->getLinksNavigate()->each() as $link) echo $link; ?>
	</div>
	<h1><?= $title; ?></h1>
	<form action = "<?= $action->path((array)$editor->params); ?>">
		<?php
			echo csrf();
			foreach ($fields->each() as /** @var Base\Editor\Skins\Skin $field */ $field) if ($field->isHide()) echo $field->format($item[$field->getName()] ?? '');
		?>
		<table class = "create">
			<tbody>
			<?php foreach ($fields->each() as /** @var Base\Editor\Skins\Skin $field */ $field) { if ($field->isHide()) continue; ?>
				<tr>
					<th><?= $field->getTitle(); ?>:</th>
					<td><?= $field->format(''); ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<input type = "submit" value = "<?= $textBtn; ?>" onclick = "<?= $action->click(); ?>">
	</form>
</div>