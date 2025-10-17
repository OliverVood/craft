<?php

	declare(strict_types=1);

	namespace Base;

	use Exception;

	/**
	 * Контроллеры
	 * @property Controller[] $controllers
	 */
	class Controllers {
		const SOURCE_CONTROLLERS = 1;
		const SOURCE_EDITORS = 2;

		private array $controllers = [];

		private static array $history = [];

		/**
		 * Регистрирует контроллер
		 * @param string $name - Наименование контроллера
		 * @param int $source - Источник
		 * @return void
		 */
		private function registration(string $name, int $source): void {
			$this->load($name, $source);
			$this->init($name, $source);
		}

		/**
		 * Загружает контроллер
		 * @param string $name - Наименование контроллера
		 * @param int $source - Источник
		 * @return void
		 */
		private function load(string $name, int $source): void {
			$path = str_replace('.', '/', $name);
			$file = match ($source) {
				self::SOURCE_CONTROLLERS =>  DIR_PROJ_CONTROLLERS . $path . '.php',
				self::SOURCE_EDITORS => DIR_PROJ_EDITORS_CONTROLLERS . $path . '.php',
			};

			if (!file_exists($file)) app()->error(new Exception('Controller not found'));

			require_once $file;
		}

		/**
		 * Инициализирует контроллер
		 * @param string $name - Наименование контроллера
		 * @param int $source - Источник
		 * @return void
		 */
		private function init(string $name, int $source): void {
			$path = str_replace('.', '\\', $name);
			$class = match ($source) {
				self::SOURCE_CONTROLLERS => "\\Proj\\Controllers\\{$path}",
				self::SOURCE_EDITORS => "\\Proj\\Editors\\Controllers\\{$path}",
				default => die('Unexpected match value')
			};

			if (!class_exists($class)) app()->error(new Exception('Controller not found'));

			$this->controllers[$name] = new $class();
		}

		/**
		 * Возвращает контроллер по имени
		 * @param string $name - Наименование контроллера
		 * @return Controller
		 */
		public function get(string $name): Controller {
			return $this->controllers[$name];
		}

		/**
		 * Регистрирует и возвращает контроллер
		 * @param string $name - Наименование контроллера
		 * @param int $source - Источник
		 * @return Controller
		 */
		public function registrationAndGet(string $name, int $source): Controller {
			if (!isset($this->controllers[$name])) $this->registration($name, $source);

			return $this->get($name);
		}

		/**
		 * Запускает контроллер
		 * @param int $source - Источник
		 * @param string $name - Наименование контроллера
		 * @param string $method - Метод
		 * @param array $params - Параметры запроса
		 * @return void
		 */
		public function run(int $source, string $name, string $method, array $params): void {
			$class = $this->registrationAndGet($name, $source);

			if (!method_exists($class, $method)) app()->error(new Exception('Controller method not found'));

			self::addToHistory("{$name}::{$method}");

			call_user_func_array([$class, $method], [request()->data(), ...$params]);
		}

		/**
		 * Добавляет вызов в историю
		 * @param string $call - Вызов
		 * @return void
		 */
		private function addToHistory(string $call): void {
			self::$history[] = $call;
		}

		/**
		 * Возвращает историю вызовов
		 * @return array
		 */
		public static function getHistory(): array {
			return self::$history;
		}

	}