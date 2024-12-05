<?php

	namespace Base\Editor\Skins;

	use Base\Editor\Fields;
	use Base\Editor\Skins\Browse\Date;
	use Base\Editor\Skins\Browse\Int2IP;
	use Base\Editor\Skins\Browse\Text;

	require DIR_BASE . 'editor/skins/browse/Text.php';
	require DIR_BASE . 'editor/skins/browse/Date.php';
	require DIR_BASE . 'editor/skins/browse/Int2IP.php';

	class Browse {
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
		 * Дата/время
		 * @param string $name - Имя поля
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function date(string $name, string $title = ''): void {
			$this->skin->push($name, new Date($name, $title));
		}

		/**
		 * Поле IP-адреса записанного, как целое число
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function int2IP(string $name, string $title = ''): void {
			$this->skin->push($name, new Int2IP($name, $title));
		}

	}