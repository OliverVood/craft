<?php

	namespace Base;

	use base\data\set\Input;

	/**
	 * Базовый класс для работы с контроллерами
	 */
	abstract class Controller {
		private static /** @var Controller[] */ array $controllers = [];
		protected int $id;

		public function __construct(int $id) {
			$this->id = $id;
		}

		/**
		 * Запускает контроллера
		 * @param int $source - Источник
		 * @param string $controller - Наименование контроллера
		 * @param string $method - Метод
		 * @param Input $input - Пользовательские данные
		 * @return void
		 */
		public static function run(int $source, string $controller, string $method, Input $input): void {
			$instance = self::get($controller, $source);
			if ($method) call_user_func_array([$instance, $method], [$input]);
		}

		/**
		 * Возвращает контроллер
		 * @param string $controller - Название контроллера
		 * @param int $source - Источник
		 * @return self
		 */
		public static function get(string $controller, int $source): self {
			if (!isset(self::$controllers[$controller])) {
				self::load($controller, $source);
				self::init($controller, $source);
			}
			return self::$controllers[$controller];
		}

		/**
		 * Загружает контроллер
		 * @param string $controller - Наименование контроллера
		 * @param int $source - Источник
		 * @return void
		 */
		public static function load(string $controller, int $source): void {
			$controllerPath = str_replace('.', '/', $controller);
			switch ($source) {
				case Route::SOURCE_CONTROLLERS: require_once DIR_PROJ_CONTROLLERS . $controllerPath . '.php'; break;
				case Route::SOURCE_EDITORS: require_once DIR_PROJ_EDITORS_CONTROLLERS . $controllerPath . '.php'; break;
			}
		}

		/**
		 * Инициализирует контроллер
		 * @param string $controller - Наименование контроллера
		 * @param int $source - Источник
		 * @return void
		 */
		public static function init(string $controller, int $source): void {
			$controllerPath = str_replace('.', '\\', $controller);
			$class = match ($source) {
				Route::SOURCE_CONTROLLERS => "\\Proj\\Controllers\\{$controllerPath}",
				Route::SOURCE_EDITORS => "\\Proj\\Editors\\Controllers\\{$controllerPath}",
				default => die('Unexpected match value')
			};
			self::$controllers[$controller] = new $class();
		}

		/**
		 * Возвращает модель
		 * @param string $name - Наименование модели
		 * @return Model
		 */
		public function model(string $name): Model {
			return Model::get($name);
		}

		/**
		 * Проверяет права
		 * @param int $right - Право
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function allow(int $right, int $id = 0): bool {
			return Access::allow($right, $this->id, $id);
		}

	}