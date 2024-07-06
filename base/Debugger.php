<?php

	namespace Base;

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
		public static function Dump(mixed $var, string $title = ''): void { ?>
			<b><?= $title; ?></b>
			<pre><?php var_dump($var); ?></pre>
		<?php }

		/**
		 * Печатает переменную и завершает работу программы
		 * @param mixed $var - Переменная
		 * @param string $title - Заголовок
		 * @return void
		 */
		#[NoReturn] public static function DumpAndDie(mixed $var, string $title = ''): void {
			self::Dump($var, $title);
			die();
		}

	}