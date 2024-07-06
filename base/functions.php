<?php

	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Печатает переменную
	 * @param mixed $var - Переменная
	 * @param string $title - Заголовок
	 * @return void
	 */
	function dump(mixed $var, string $title = ''): void {
		Base\Debugger::Dump($var, $title);
	}

	/**
	 * Печатает переменную и завершает программу
	 * @param mixed $var - Переменная
	 * @param string $title - Заголовок
	 * @return void
	 */
	#[NoReturn] function dd(mixed $var, string $title = ''): void {
		Base\Debugger::DumpAndDie($var, $title);
	}

	/**
	 * Возвращает перевод
	 * @param $alias - Псевдоним перевода
	 * @return string
	 */
	function __($alias): string {
		if ($alias == 'Войти') $alias = 'Login';
		return $alias;
	}