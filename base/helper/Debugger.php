<?php

	namespace Base\Helper;

	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Отладчик
	 */
	abstract class Debugger {
		/**
		 * Печатает переменную
		 * @param mixed $var - Переменная
		 * @param string $title - Заголовок
		 * @return void
		 */
		public static function dump(mixed $var, string $title = ''): void { ?>
			<b><?= $title; ?></b>
			<pre><?php var_dump($var); ?></pre>
		<?php }

		/**
		 * Печатает переменную и завершает работу программы
		 * @param mixed $var - Переменная
		 * @param string $title - Заголовок
		 * @return void
		 */
		#[NoReturn] public static function dd(mixed $var, string $title = ''): void {
			self::dump($var, $title);
			die();
		}

	}