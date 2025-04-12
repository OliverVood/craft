<?php

	declare(strict_types=1);

	namespace Base\Editor\Skins\Edit;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для отображения многострочного текстового поля
	 */
	class Textarea extends Skin {
		public function __construct(string $name, string $title = '') {
			parent::__construct('textarea', $name, $title);
		}

		/**
		 * Возвращает многострочное текстовое поле
		 * @param string $value - Значение
		 * @return string
		 */
		public function format(string $value): string {
			buffer()->start();
			?>
				<textarea name = "<?= $this->name; ?>"><?= $value; ?></textarea>
			<?php
			return buffer()->read();
		}

	}