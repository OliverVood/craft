<?php
	/** @var stdClass $menu */

	/**
	 * Выводит меню
	 * @param stdClass $item - Элемент
	 * @return string
	 */
	function renderMenu(stdClass $item): string {
		return match($item->type) {
			'block' => renderBlock($item->data),
			'group' => renderGroup($item->data),
			'link' => renderLink($item->data),
			'separator' => renderSeparator(),
		};
	}

	/**
	 * Выводит блок
	 * @param $block - Данные блока
	 * @return string
	 */
	function renderBlock($block): string {
		buffer()->start();
		?>
		<div class = "block close">
			<div class = "head" onclick = "toggleMenuItem(el(this));"><?= $block->head; ?></div>
			<div class = "list">
				<?php foreach ($block->items as $item) { echo renderMenu($item); } ?>
			</div>
		</div>
		<?php
		return buffer()->read();
	}

	/**
	 * Выводит группу
	 * @param $group - Данные группы
	 * @return string
	 */
	function renderGroup($group): string {
		buffer()->start();
		?>
		<div class = "group close">
			<div class = "head" onclick = "toggleMenuItem(el(this));">
				<div class = "icon <?= $group->icon; ?>"></div>
				<div class = "text"><?= $group->head; ?></div>
			</div>
			<div class = "list">
				<?php foreach ($group->items as $item) { echo renderMenu($item); } ?>
			</div>
		</div>
		<?php
		return buffer()->read();
	}

	/**
	 * Выводит ссылку
	 * @param stdClass $link - Данные ссылки
	 * @return string
	 */
	function renderLink(stdClass $link): string {
		$out = match ($link->type) {
			'external' => linkExternal($link->name)->hyperlink($link->text, $link->data, $link->params),
			'internal' => linkInternal($link->name)->hyperlink($link->text, $link->data, $link->params),
			'right' => linkRight($link->name)->hyperlink($link->text, $link->data, $link->params),
			default => $link->text,
		};

		return "<div class = \"m_link\">{$out}</div>";
	}

	/**
	 * Выводит разделитель
	 * @return string
	 */
	function renderSeparator(): string {
		return '<div class = "separator"></div>';
	}

?>
<div class = "view out menu">
	<?php
		foreach ($menu->items as $item) {
			echo renderMenu($item);
		}
	?>
</div>