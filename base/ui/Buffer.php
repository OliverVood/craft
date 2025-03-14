<?php

	declare(strict_types=1);

	namespace Base\UI;

	use Base\Singleton;

	/**
	 * Буферизация вывода
	 */
	class Buffer {
		use Singleton;

		/**
		 * Создает новый буфер в стеке
		 * @return void
		 */
		public function start(): void {
			ob_start();
		}

		/**
		 * Возвращает содержимое буфера из стека и удаляет этот буфер из стека
		 * @return string
		 */
		public function read(): string {
			$val = ob_get_contents();
			ob_end_clean();

			return $val !== false ? $val : '';
		}

	}