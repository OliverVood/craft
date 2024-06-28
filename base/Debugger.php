<?php

	namespace Base;

	use JetBrains\PhpStorm\NoReturn;

	abstract class Debugger {
		public static function Dump(mixed $var, string $title = ''): void { ?>
			<b><?= $title; ?></b>
			<pre><?php var_dump($var); ?></pre>
		<?php }

		#[NoReturn] public static function DumpAndDie(mixed $var, string $title = ''): void {
			self::Dump($var, $title);
			die();
		}

	}