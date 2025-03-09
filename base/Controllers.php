<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Класс контроллеров
	 * @property Controller[] $controllers
	 */
	class Controllers {
		const SOURCE_CONTROLLERS = 1;
		const SOURCE_EDITORS = 2;

		private array $controllers = [];

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
			switch ($source) {
				case self::SOURCE_CONTROLLERS: require_once DIR_PROJ_CONTROLLERS . $path . '.php'; break;
				case self::SOURCE_EDITORS: require_once DIR_PROJ_EDITORS_CONTROLLERS . $path . '.php'; break;
			}
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
		public function regAndGet(string $name, int $source): Controller {
			if (!isset($this->controllers[$name])) $this->registration($name, $source);

			return $this->get($name);
		}
		/**
		 * Запускает контроллера
		 * @param int $source - Источник
		 * @param string $name - Наименование контроллера
		 * @param string $method - Метод
		 * @return void
		 */
		public function run(int $source, string $name, string $method): void {
			call_user_func_array([$this->regAndGet($name, $source), $method], [request()->data()]);
		}

	}