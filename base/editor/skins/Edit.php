<?php

	namespace Base\Editor\Skins;

	use Base\Editor\Fields;
	use Base\Editor\Skins\Edit\Hidden;
	use Base\Editor\Skins\Edit\Text;

	require DIR_BASE . 'editor/skins/edit/Text.php';
	require DIR_BASE . 'editor/skins/edit/Hidden.php';
//	require DIR_BASE . 'editor/skins/browse/Date.php';
//	require DIR_BASE . 'editor/skins/browse/Int2IP.php';

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
		 * Скрытый текст
		 * @param string $name - Наименование
		 * @return void
		 */
		public function hidden(string $name): void {
			$this->skin->push($name, new Hidden($name));
		}

	}