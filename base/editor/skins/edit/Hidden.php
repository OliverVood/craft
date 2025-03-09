<?php

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
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			$this->start();
			?>
				<input type = "hidden" name = "<?= $this->name; ?>" value = "<?= $value; ?>">
			<?php
			return $this->read();
		}

	}