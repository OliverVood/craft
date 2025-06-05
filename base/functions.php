<?php

	declare(strict_types=1);

	use Base\Access;
	use Base\App;
	use Base\Data\Defined;
	use Base\Data\Old;
	use Base\DB\DB;
	use Base\Helper\Cryptography;
	use Base\Helper\Debugger;
	use Base\Helper\Response;
	use Base\Helper\Security;
	use Base\Helper\Translation;
	use Base\Helper\Validator;
	use Base\Link\External;
	use Base\Link\Internal;
	use Base\Link\Right;
	use Base\Model;
	use Base\Models;
	use Base\Request;
	use Base\Route;
	use Base\Templates;
	use Base\UI\Buffer;
	use Base\UI\Component;
	use Base\UI\Template;
	use Base\UI\View;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models\Users;

	/**
	 * Возвращает / инициализирует экземпляр приложения
	 * @param string $html - Относительный путь точки входа HTML
	 * @param string $xhr - Относительный путь точки входа XHR
	 * @return App
	 */
	function app(string $html = '', string $xhr = ''): App {
		return App::instance($html, $xhr);
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
	 * Возвращает объект запроса
	 * @return Response
	 */
	function response(): Response {
		return app()->response();
	}

	/**
	 * Возвращает модель
	 * @param string $name - Наименование модели
	 * @param int $source - Источник
	 * @return Model
	 */
	function model(string $name, int $source = Models::SOURCE_MODELS): Model {
		return app()->models->registrationAndGet($name, $source);
	}

	/**
	 * Возвращает базу данных по псевдониму
	 * @param string $alias - Псевдоним базы данных
	 * @return DB
	 */
	function db(string $alias): DB {
		return app()->dbs->registrationAndGet($alias);
	}

	/**
	 * Возвращает объект доступа
	 * @return Access
	 */
	function access(): Access {
		return app()->access();
	}

	/**
	 * Проверяет право
	 * @param string $feature - Наименование признака
	 * @param string $right - Наименование права
	 * @param int $id - Идентификатор
	 * @return bool
	 */
	function allow(string $feature, string $right, int $id = 0): bool {
		return app()->access->allow(app()->features($feature)->id(), app()->features($feature)->rights($right)->id(), $id);
	}

	/**
	 * Возвращает переменную окружения
	 * @param $key - Ключ
	 * @param $default - Значение по умолчанию
	 * @return mixed
	 */
	function env($key, $default = null): mixed {
		return app()->config()->get($key, $default);
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
	 * @param bool $exp - Вызывать ли исключение
	 * @return Right|null
	 */
	function linkRight(string $alias, bool $exp = true): ?Right {
		return app()->links->getRight($alias, $exp);
	}

	/**
	 * Возвращает шаблон
	 * @param string $name - Наименование шаблона
	 * @return Template
	 */
	function template(string $name = ''): Template {
		return Templates::instance()->registrationAndGet($name ?: app()->params->defaultTemplate);
	}

	/**
	 * Возвращает отображение
	 * @param string $name - Наименование отображения
	 * @param array $data - Данные
	 * @param bool $showName - Показывать ли имя отображения
	 * @param bool $showVarsKeys - Показывать ли ключи переменных
	 * @param bool $showVars - Показывать ли переменные
	 * @return string
	 */
	function view(string $name, array $data = [], bool $showName = false, bool $showVarsKeys = false, bool $showVars = false): string {
		return View::get($name, $data, $showName, $showVarsKeys, $showVars);
	}

	/**
	 * Возвращает класс компонентов
	 * @return Component
	 */
	function component(): Component {
		return Component::instance();
	}

	/**
	 * Возвращает класс буферизации
	 * @return Buffer
	 */
	function buffer(): Buffer {
		return Buffer::instance();
	}

	/**
	 * Возвращает значение из $_POST или $_GET по ключу
	 * @param string $key - Ключ
	 * @param mixed|null $default - Значение по умолчанию
	 * @return mixed
	 */
	function input(string $key, mixed $default = null): mixed {
		return request()->data()->input()->data()->$key ?? $default;
	}

	/**
	 * Возвращает значение из $_POST или $_GET по ключу
	 * @param string|null $key - Ключ
	 * @return mixed
	 */
	function definite(?string $key = null): Defined {
		return request()->data()->defined($key);
	}

	/**
	 * Возвращает данные от предыдущего запроса
	 * @param string|null $key - Ключ
	 * @return Old
	 */
	function old(?string $key = null): Old {
		return request()->data()->old($key);
	}

	/**
	 * Печатает переменную
	 * @param mixed $var - Переменная
	 * @param string $title - Заголовок
	 * @return void
	 */
	function dump(mixed $var, string $title = ''): void {
		Debugger::dump($var, $title);
	}

	/**
	 * Печатает переменную и завершает программу
	 * @param mixed $var - Переменная
	 * @param string $title - Заголовок
	 * @return void
	 */
	#[NoReturn] function dd(mixed $var, string $title = ''): void {
		Debugger::dd($var, $title);
	}

	/**
	 * Возвращает перевод
	 * @param $alias - Псевдоним перевода
	 * @param array $params - Параметры замены
	 * @return string
	 */
	function __($alias, array $params = []): string {
		return Translation::get($alias, $params);
	}

	/**
	 * Валидация данных
	 * @param $data - Данные
	 * @param array $names - Массив псевдонимов и имён
	 * @param $rules - Правила
	 * @param array $errors - Ошибки
	 * @return array|null
	 */
	function validation(array $data, array $rules, array $names = [], array & $errors = []): ?array {
		return Validator::execute($data, $rules, $names, $errors);
	}

	/**
	 * Выполняет шифрование
	 * @param string $string - Строка
	 * @return string
	 */
	function encryption(string $string): string {
		return Cryptography::encryption($string);
	}

	/**
	 * Возвращает поле для метода PATCH
	 * @return string
	 */
	function patch(): string { buffer()->start(); ?>
		<input type = "hidden" name = "__method" value = "patch">
	<?php return buffer()->read();
	}

	/**
	 * Возвращает поле CSRF
	 * @return string
	 */
	function csrf(): string {
		/** @var Users $user */ $user = model('users');
		buffer()->start();
		?><input type = "hidden" name = "__csrf" value = "<?= $user->hash(); ?>"><?php
		return buffer()->read();
	}

	/**
	 * Валидация CSRF
	 * @return bool
	 */
	function csrfValidate(): bool {
		/** @var Users $user */ $user = model('users');

		if (!$user->isAuth()) return true;
		if (!$hash = $user->hash()) return false;
		if (!$csrf = request()->data()->defined('__csrf')->string('')) return false;

		return $hash == $csrf;
	}

	/**
	 * Возвращает хеш пользователя
	 * @return string
	 */
	function getUserHash(): string {
		/** @var Users $user */ $user = model('users');
		return $user->hash();
	}