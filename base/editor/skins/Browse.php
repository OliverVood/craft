<?php

	namespace Base\Editor\Skins;

	use Base\Editor\Fields;
	use Base\Editor\Skins\Browse\DateTime;
	use Base\Editor\Skins\Browse\Int2IP;
	use Base\Editor\Skins\Browse\Text;
	use Base\Editor\Skins\Browse\ValueFromArray;

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
		 * @param string $format - Формат
		 * @return void
		 */
		public function datetime(string $name, string $title = '', $format = 'd.m.Y H:i:s'): void {
			$this->skin->push($name, new DateTime($name, $title, $format));
		}

		/**
		 * Дата/время
		 * @param string $name - Имя поля
		 * @param string $title - Заголовок
		 * @param string $format - Формат
		 * @return void
		 */
		public function datetimeClient(string $name, string $title = '', $format = 'd.m.Y H:i:s'): void {
			$this->skin->push($name, new DateTime($name, $title, $format, true));
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

		/**
		 * Вывод значения из массива по ключу
		 * @param string $name - Наименование
		 * @param string $title - Заголовок
		 * @param array $array - Массив
		 * @return void
		 */
		public function fromArray(string $name, string $title = '', array $array = []): void {
			$this->skin->push($name, new ValueFromArray($name, $title, $array));
		}

	}

	require DIR_BASE . 'editor/skins/browse/Text.php';
	require DIR_BASE . 'editor/skins/browse/DateTime.php';
	require DIR_BASE . 'editor/skins/browse/Int2IP.php';
	require DIR_BASE . 'editor/skins/browse/ValueFromArray.php';