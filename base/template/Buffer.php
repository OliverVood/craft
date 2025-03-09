<?php

	declare(strict_types=1);

	namespace Base\Template;

	/**
	 * Буферизация вывода
	 */
	class Buffer {

		/**
		 * Создает новый буфер в стеке
		 * @return void
		 */
		public static function start(): void {
			ob_start();
		}

		/**
		 * Возвращает содержимое буфера из стека и удаляет этот буфер из стека
		 * @return string
		 */
		public static function read(): string {
			$val = ob_get_contents();
			ob_end_clean();

			return $val !== false ? $val : '';
		}

	}