<?php

	namespace Base\Editor\Skins\Edit;

	class File extends Input {
		private string $value;
		private string $accept;

		public function __construct(string $name, string $title = '', string $value = 'Выберите', string $accept = '') {
			parent::__construct('file', $name, $title);

			$this->value = $value;
			$this->accept = $accept;
		}

		/**
		 * Возвращает поле файл
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			$accept = $this->accept ? ' accept = "' . $this->accept . '"' : '';
			buffer()->start();
			?>
				<input type = "<?= $this->type; ?>" name = "<?= $this->name; ?>" value = "<?= $this->value; ?>"<?= $accept; ?>>
			<?php
			return $this->cover(buffer()->read());
		}

	}