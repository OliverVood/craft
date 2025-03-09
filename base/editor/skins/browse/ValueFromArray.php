<?php

	namespace Base\Editor\Skins\Browse;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для вывода значения из массива по ключу
	 */
	class ValueFromArray extends Skin {
		private array $array;
		public function __construct(string $name, string $title = '', array $array = []) {
			parent::__construct('text', $name, $title);

			$this->array = $array;
		}

		/**
		 * Форматирует и возвращает текст
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			return $this->array[$value];
		}

	}