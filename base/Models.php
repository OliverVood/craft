<?php

	declare(strict_types=1);

	namespace Base;

	use Exception;

	/**
	 * Модели
	 * @property Model[] $models
	 */
	class Models {
		const SOURCE_MODELS = 1;
		const SOURCE_EDITORS = 2;

		private array $models = [];

		private static array $history = [];

		/**
		 * Регистрирует модель
		 * @param string $name - Наименование модели
		 * @param int $source - Источник
		 * @return void
		 */
		private function registration(string $name, int $source): void {
			$this->load($name, $source);
			$this->init($name, $source);
		}

		/**
		 * Загружает модель
		 * @param string $name - Название модели
		 * @param int $source - Источник
		 * @return void
		 */
		public function load(string $name, int $source): void {
			$path = str_replace('.', '/', $name);
			$file = match ($source) {
				self::SOURCE_MODELS => DIR_PROJ_MODELS . $path . '.php',
				self::SOURCE_EDITORS => DIR_PROJ_EDITORS_MODELS . $path . '.php',
			};

			if (!file_exists($file)) app()->error(new Exception(__("Model ':[name]' not found", ['name' => $name])));

			require_once $file;
		}

		/**
		 * Инициализирует модель
		 * @param string $name - Наименование модели
		 * @param int $source - Источник
		 * @return void
		 */
		private function init(string $name, int $source): void {
			$path = str_replace('.', '\\', $name);
			$class = match ($source) {
				self::SOURCE_MODELS => "\\Proj\\Models\\{$path}",
				self::SOURCE_EDITORS => "\\Proj\\Editors\\Models\\{$path}",
				default => die('Unexpected match value')
			};
			$this->models["{$name}.{$source}"] = new $class();

			self::addToHistory($class);
		}

		/**
		 * Возвращает модель по имени
		 * @param string $name - Наименование контроллера
		 * @return Model
		 */
		private function get(string $name): Model {
			return $this->models[$name];
		}

		/**
		 * Регистрирует и возвращает модель
		 * @param string $name - Наименование модели
		 * @param int $source - Источник
		 * @return Model
		 */
		public function registrationAndGet(string $name, int $source): Model {
			if (!isset($this->models["{$name}.{$source}"])) $this->registration($name, $source);

			return $this->get("{$name}.{$source}");
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