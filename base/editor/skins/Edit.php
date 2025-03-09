<?php

	namespace Base\Editor\Skins;

	use Base\Editor\Fields;
	use Base\Editor\Skins\Edit\Hidden;
	use Base\Editor\Skins\Edit\Password;
	use Base\Editor\Skins\Edit\Select;
	use Base\Editor\Skins\Edit\Text;

	class Edit {
		protected Fields $skin;

		public function __construct(Fields $skin) {
			$this->skin = $skin;
		}

		/**
		 * Текст
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function text(string $name, string $title = ''): void {
			$this->skin->push($name, new Text($name, $title));
		}

		/**
		 * Текст
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function password(string $name, string $title = ''): void {
			$this->skin->push($name, new Password($name, $title));
		}

		/**
		 * Скрытый текст
		 * @param string $name - Наименование
		 * @return void
		 */
		public function hidden(string $name): void {
			$this->skin->push($name, new Hidden($name));
		}

		/**
		 * Селект
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @param array $data - Данные
		 * @param array $params - Параметры
		 * @return void
		 */
		public function select(string $name, string $title = '', array $data = [], array $params = []): void {
			$this->skin->push($name, new Select($name, $title, $data, $params));
		}

	}

	require DIR_BASE . 'editor/skins/edit/Input.php';
	require DIR_BASE . 'editor/skins/edit/Hidden.php';
	require DIR_BASE . 'editor/skins/edit/Select.php';