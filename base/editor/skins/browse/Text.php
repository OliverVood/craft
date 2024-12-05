<?php

	namespace Base\Editor\Skins\Browse;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для вывода текста
	 */
	class Text extends Skin {
		public function __construct(string $name, string $title = '') {
			parent::__construct('text', $name, $title);
		}

		/**
		 * Форматирует и возвращает текст
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			return nl2br(htmlspecialchars($value));
		}

	}