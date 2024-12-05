<?php

	use Base\Controller;
	use Base\Data\Set\Old;
	use Base\Model;
	use Base\Route;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Печатает переменную
	 * @param mixed $var - Переменная
	 * @param string $title - Заголовок
	 * @return void
	 */
	function dump(mixed $var, string $title = ''): void {
		Base\Debugger::dump($var, $title);
	}

	/**
	 * Печатает переменную и завершает программу
	 * @param mixed $var - Переменная
	 * @param string $title - Заголовок
	 * @return void
	 */
	#[NoReturn] function dd(mixed $var, string $title = ''): void {
		Base\Debugger::dd($var, $title);
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

	/**
	 * Возвращает данные от предыдущего запроса
	 * @param string|null $key - Ключ
	 * @return Old
	 */
	function old(?string $key = null): Old {
		return Route::getOld($key);
	}

	/**
	 * Возвращает контроллер
	 * @param string $name - Наименование контроллера
	 * @return Controller
	 * @throws Exception
	 */
	function controller(string $name): Controller {
		return Controller::get($name, Route::SOURCE_CONTROLLERS);
	}

	/**
	 * Возвращает контроллер-редактор
	 * @param string $name - Наименование контроллера
	 * @return Controller
	 */
	function controllerEditor(string $name): Controller {
		return Controller::get($name, Route::SOURCE_EDITORS);
	}

	/**
	 * Возвращает модель
	 * @param string $name - Наименование модели
	 * @return Model
	 */
	function model(string $name): Model {
		return Model::get($name);
	}

	/**
	 * Возвращает модель-редактор
	 * @param string $name - Наименование модели
	 * @return Model
	 */
	function modelEditor(string $name): Model {
		return Model::get($name, Model::SOURCE_EDITORS);
	}