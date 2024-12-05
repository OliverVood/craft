<?php

	namespace Base\Editor\Skins\Edit;

	use Base\Editor\Skins\Skin;
	use Base\Template\Buffer;

	/**
	 * Скин для отображения текстового поля
	 */
	class Text extends Skin {
		use Buffer;

		public function __construct(string $name, string $title = '') {
			parent::__construct('text', $name, $title);
		}

		/**
		 * Возвращает текстовое поле
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			$this->start();
			?>
				<input type = "text" name = "<?= $this->name; ?>" value = "<?= $value; ?>">
			<?php
			return $this->read();
		}

	}