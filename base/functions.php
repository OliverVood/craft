<?php

	use JetBrains\PhpStorm\NoReturn;

	function dump(mixed $var, string $title = ''): void {
		Base\Debugger::Dump($var, $title);
	}

	#[NoReturn] function dd(mixed $var, string $title = ''): void {
		Base\Debugger::DumpAndDie($var, $title);
	}