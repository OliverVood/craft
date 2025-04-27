<?php

	use Base\Access\Feature;
	use Base\Access\Features;
	use Base\Access\Right;
	use Base\Editor\Skins\Edit\Hidden;

	/** @var int $id */
	/** @var string $title */
	/** @var array $items */
	/** @var Features $features */
	/** @var Base\Link\Right $action */
	/** @var string $textBtn */
	/** @var Base\Editor\Controller $editor */
?>
<div class = "view editor access">
	<div class = "navigate">
		<?php
			$fnGetLinksNavigate = $editor->access->fnGetLinksNavigate;
			foreach ($fnGetLinksNavigate()->each() as $link) echo $link; ?>
	</div>
	<h1><?= $title; ?></h1>
	<form action = "<?= $action->path(['id' => $id]); ?>" enctype="multipart/form-data" class = "cn-mb-1">
		<?php
			echo csrf();
			foreach ($features->each() as /** @var Feature $feature */ $feature) {
				if (!$feature->issetRight('access')) continue;
				if (!allow($feature->name(), 'access')) continue;
				?>
				<h3 class = "cn-mb-1"><?= $feature->title(); ?></h3>
				<table class = "select cn-mb-1">
					<thead>
					<tr>
						<th>Право</th>
						<th>Не выбрано</th>
						<th>Разрешено</th>
						<th>Запрещено</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($feature->rightsEach() as /** @var Right $right */ $right) { ?>
						<tr>
							<td><?= $right->title(); ?></td>
							<td class = "cn-center"><input type = "radio" name = "rights[<?= $feature->id(); ?>][<?= $right->id(); ?>]" value = "<?= Base\Access::PERMISSION_UNDEFINED; ?>"<?= (isset($items[$feature->id()][$right->id()]) && ($items[$feature->id()][$right->id()] == Base\Access::PERMISSION_UNDEFINED)) ? ' checked': ''; ?>></td>
							<td class = "cn-center"><input type = "radio" name = "rights[<?= $feature->id(); ?>][<?= $right->id(); ?>]" value = "<?= Base\Access::PERMISSION_YES; ?>"<?= (isset($items[$feature->id()][$right->id()]) && ($items[$feature->id()][$right->id()] == Base\Access::PERMISSION_YES)) ? ' checked': ''; ?>></td>
							<td class = "cn-center"><input type = "radio" name = "rights[<?= $feature->id(); ?>][<?= $right->id(); ?>]" value = "<?= Base\Access::PERMISSION_NO; ?>"<?= (isset($items[$feature->id()][$right->id()]) && ($items[$feature->id()][$right->id()] == Base\Access::PERMISSION_NO)) ? ' checked': ''; ?>></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		<input type = "submit" value = "<?= $textBtn; ?>" onclick = "<?= $action->click(); ?>">
	</form>
</div>