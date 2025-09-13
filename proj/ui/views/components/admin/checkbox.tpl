<?php
	/** @var string $text */
	/** @var array $attributes */

	$attrs = array_map(function ($key, $value) { $value = str_replace('"', '&#34', $value); return "{$key} = \"{$value}\""; }, array_keys($attributes), $attributes);
?>
<div class = "component checkbox">
	<label>
		<input type = "checkbox" <?= implode(' ', $attrs); ?> onclick = "this.checked ? this.closest('.component.checkbox').classList.add('active') : this.closest('.component.checkbox').classList.remove('active');">
		<div></div>
		<?php if ($text !== '') { ?><span><?= $text; ?></span><?php } ?>
	</label>
</div>