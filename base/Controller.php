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
		 * @param string $controller - Наименование контроллера
		 * @param string $method - Метод
		 * @param Input $input - Пользовательские данные
		 * @return void
		 */
		public static function run(string $controller, string $method, Input $input): void {
			if (!isset(self::$controllers[$controller])) {
				self::load($controller);
				self::init($controller);
			}
			call_user_func_array([self::$controllers[$controller], $method], [$input]);
		}

		/**
		 * Загружает контроллер
		 * @param string $controller - Наименование контроллера
		 * @return void
		 */
		public static function load(string $controller): void {
			$controllerPath = str_replace('.', '/', $controller);
			require_once DIR_PROJ_CONTROLLERS . $controllerPath . '.php';
		}

		/**
		 * Инициализирует контроллер
		 * @param string $controller - Наименование контроллера
		 * @return void
		 */
		public static function init(string $controller): void {
			$controllerPath = str_replace('.', '\\', $controller);
			$class = "\\proj\\controllers\\{$controllerPath}";
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

	}