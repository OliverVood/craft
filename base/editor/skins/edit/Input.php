<?php

	declare(strict_types=1);

	namespace Base\Editor\Skins\Edit;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для отображения текстового поля
	 */
	abstract class Input extends Skin {
		public function __construct(string $type, string $name, string $title = '') {
			parent::__construct($type, $name, $title);
		}

		/**
		 * Возвращает текстовое поле
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			buffer()->start();
			?>
				<input type = "<?= $this->type; ?>" name = "<?= $this->name; ?>" value = "<?= $value; ?>">
			<?php
			return $this->cover(buffer()->read());
		}

	}

	require DIR_BASE . 'editor/skins/edit/Text.php';
	require DIR_BASE . 'editor/skins/edit/Password.php';