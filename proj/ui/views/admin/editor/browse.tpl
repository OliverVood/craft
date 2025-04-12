<?php
	/** @var string $title */
	/** @var Base\Editor\Fields $fields */
	/** @var array $item */
	/** @var Base\Editor\Controller $editor */
?>
<div class = "view editor browse">
	<div class = "navigate">
		<?php foreach ($editor->browse->getLinksNavigate($item)->each() as $link) echo $link; ?>
	</div>
	<h1><?= $title; ?></h1>
	<table class = "browse">
		<tbody>
		<?php foreach ($fields->each() as /** @var Base\Editor\Skins\Skin $field */$field) { ?>
			<tr>
				<th><?= $field->getTitle(); ?>:</th>
				<td><?= $field->format($item[$field->getName()]); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>