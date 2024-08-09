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

	/**
	 * Возвращает значение из $_POST или $_GET по ключу
	 * @param string $key - Ключ
	 * @param mixed|null $default - Значение по умолчанию
	 * @return mixed
	 */
	function input(string $key, mixed $default = null): mixed {
		return $_POST[$key] ?? $_GET[$key] ?? $default;
	}