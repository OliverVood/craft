<?php

	declare(strict_types=1);

	namespace Base\Editor\Skins\Edit;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для отображения скрытого текстового поля
	 */
	class Hidden extends Skin {
		public function __construct(string $name, string $title = '') {
			parent::__construct('hidden', $name, $title, true);
		}

		/**
		 * Возвращает скрытое текстовое поле
		 * @param int|string $value
		 * @return string
		 */
		public function format(int|string $value): string {
			buffer()->start();
			?>
				<input type = "hidden" name = "<?= $this->name; ?>" value = "<?= $value; ?>">
			<?php
			return buffer()->read();
		}

	}