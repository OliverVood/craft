<?php

	namespace Base\Editor;

	require DIR_BASE . 'editor/skins/Skin.php';

	use Base\Editor\Skins\Browse;
	use Base\Editor\Skins\Edit;
	use Base\Editor\Skins\Skin;
	use Generator;

	/**
	 * Класс для работы с полями редактора
	 */
	class Fields {
		public Browse $browse;
		public Edit $edit;

		protected array $fields = [];

		public function __construct() {
			$this->browse = new Browse($this);
			$this->edit = new Edit($this);
		}

		/**
		 * Собирает поля редактора
		 * @param string $name
		 * @param Skin $field
		 * @return void
		 */
		public function push(string $name, Skin $field): void {
			$this->fields[$name] = $field;
		}

		/**
		 * Организует перебор всех полей
		 * @return Generator
		 */
		public function each(): Generator {
			if (!$this->fields) return null;

			foreach ($this->fields as $field) yield $field;

			return null;
		}

	}