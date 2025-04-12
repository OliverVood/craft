<?php

	namespace Base\Editor\Skins;

	use Base\Editor\Fields;
	use Base\Editor\Skins\Edit\DateTime;
	use Base\Editor\Skins\Edit\File;
	use Base\Editor\Skins\Edit\Hidden;
	use Base\Editor\Skins\Edit\Password;
	use Base\Editor\Skins\Edit\Select;
	use Base\Editor\Skins\Edit\Text;
	use Base\Editor\Skins\Edit\Textarea;

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
		 * Дата-время
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function datetime(string $name, string $title = ''): void {
			$this->skin->push($name, new DateTime($name, $title));
		}

		/**
		 * Многострочный текст
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function textarea(string $name, string $title = ''): void {
			$this->skin->push($name, new Textarea($name, $title));
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

		/**
		 * Файл
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @param string $value - Надпись
		 * @param string $accept - Доступные файлы
		 * @return void
		 */
		public function file(string $name, string $title = '', string $value = 'Выберите', string $accept = ''): void {
			$this->skin->push($name, new File($name, $title, $value, $accept));
		}

	}

	require DIR_BASE . 'editor/skins/edit/Input.php';
	require DIR_BASE . 'editor/skins/edit/Hidden.php';
	require DIR_BASE . 'editor/skins/edit/Textarea.php';
	require DIR_BASE . 'editor/skins/edit/Select.php';