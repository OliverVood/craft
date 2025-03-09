<?php

	declare(strict_types=1);

	use Base\App;
	use Base\DB\DB;
	use Base\Link\External;
	use Base\Link\Internal;
	use Base\Link\Right;
	use Base\Model;
	use Base\Models;
	use Base\Request;
	use Base\Route;

	/**
	 * Возвращает / инициализирует экземпляр приложения
	 * @param string $version - Версия
	 * @param int $assembly - Сборка
	 * @param string $html - Относительный путь точки входа HTML
	 * @param string $xhr - Относительный путь точки входа XHR
	 * @return App
	 */
	function app(string $version = '', int $assembly = 0, string $html = '', string $xhr = ''): App {
		return App::instance($version, $assembly, $html, $xhr);
	}

	/**
	 * Возвращает / инициализирует экземпляр маршрутизатора
	 * @return Route
	 */
	function route(): Route {
		return Route::instance();
	}

	/**
	 * Возвращает объект запроса
	 * @return Request
	 */
	function request(): Request {
		return app()->request();
	}

	/**
	 * Возвращает модель
	 * @param string $name - Наименование модели
	 * @return Model
	 */
	function model(string $name): Model {
		return app()->models->regAndGet($name, Models::SOURCE_MODEL);
	}

	/**
	 * Возвращает базу данных по псевдониму
	 * @param string $alias - Псевдоним базы данных
	 * @return DB
	 */
	function db(string $alias): DB {
		return app()->dbs->initAndGet($alias);
	}

	/**
	 * Возвращает внешнюю ссылку по псевдониму
	 * @param string $alias - Псевдоним
	 * @return External
	 */
	function linkExternal(string $alias): External {
		return app()->links->getExternal($alias);
	}

	/**
	 * Возвращает внутреннюю ссылку по псевдониму
	 * @param string $alias - Псевдоним
	 * @return Internal
	 */
	function linkInternal(string $alias): Internal {
		return app()->links->getInternal($alias);
	}

	/**
	 * Возвращает ссылку с правами по псевдониму
	 * @param string $alias - Псевдоним
	 * @return Right
	 */
	function linkRight(string $alias): Right {
		return app()->links->getRight($alias);
	}

//	/**
//	 * Печатает переменную
//	 * @param mixed $var - Переменная
//	 * @param string $title - Заголовок
//	 * @return void
//	 */
//	function dump(mixed $var, string $title = ''): void {
//		Base\Debugger::dump($var, $title);
//	}
//
//	/**
//	 * Печатает переменную и завершает программу
//	 * @param mixed $var - Переменная
//	 * @param string $title - Заголовок
//	 * @return void
//	 */
//	#[NoReturn] function dd(mixed $var, string $title = ''): void {
//		Base\Debugger::dd($var, $title);
//	}
//
//	/**
//	 * Возвращает перевод
//	 * @param $alias - Псевдоним перевода
//	 * @param array $params - Параметры замены
//	 * @return string
//	 */
//	function __($alias, array $params = []): string {
//		return Translation::get($alias, $params);
//	}
//
//	/**
//	 * Возвращает значение из $_POST или $_GET по ключу
//	 * @param string $key - Ключ
//	 * @param mixed|null $default - Значение по умолчанию
//	 * @return mixed
//	 */
//	function input(string $key, mixed $default = null): mixed {
//		return $_POST[$key] ?? $_GET[$key] ?? $default;
//	}
//
//	/**
//	 * Возвращает данные от предыдущего запроса
//	 * @param string|null $key - Ключ
//	 * @return Old
//	 */
//	function old(?string $key = null): Old {
//		return Route::getOld($key);
//	}
//
//	/**
//	 * Возвращает контроллер
//	 * @param string $name - Наименование контроллера
//	 * @return Controller
//	 * @throws Exception
//	 */
//	function controller(string $name): Controller {
//		return Controller::get($name, Route::SOURCE_CONTROLLERS);
//	}
//
//	/**
//	 * Возвращает контроллер-редактор
//	 * @param string $name - Наименование контроллера
//	 * @return Controller
//	 */
//	function controllerEditor(string $name): Controller {
//		return Controller::get($name, Route::SOURCE_EDITORS);
//	}
//	/**
//	 * Возвращает модель-редактор
//	 * @param string $name - Наименование модели
//	 * @return EditorModel
//	 */
//	function modelEditor(string $name): EditorModel {
//		/** @var EditorModel $model */ $model =  EditorModel::get($name, Model::SOURCE_EDITORS);
//		return $model;
//	}
//
//	/**
//	 * Валидация данных
//	 * @param $data - Данные
//	 * @param array $names - Массив псевдонимов и имён
//	 * @param $rules - Правила
//	 * @param array $errors - Ошибки
//	 * @return array|null
//	 */
//	function validation(array $data, array $rules, array $names = [], array & $errors = []): ?array {
//		return Validator::execute($data, $rules, $names, $errors);
//	}
//
//	function encryption(string $string): string {
//		return Cryptography::encryption($string);
//	}