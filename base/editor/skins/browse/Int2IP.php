<?php

	namespace Base\Editor\Skins\Browse;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для вывода целого числа, как IP-адрес
	 */
	class Int2IP extends Skin {
		public function __construct(string $name, string $title = '') {
			parent::__construct('int2ip', $name, $title);
		}

		/**
		 * Форматирует и возвращает IP-адрес
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			return long2ip((int)$value);
		}

	}