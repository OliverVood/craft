<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Класс моделей
	 * @property Model[] $models
	 */
	class Models {
		const SOURCE_MODEL = 1;
		const SOURCE_EDITORS = 2;

		private array $models = [];

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
			switch ($source) {
				case self::SOURCE_MODEL: require_once DIR_PROJ_MODELS . $path . '.php'; break;
				case self::SOURCE_EDITORS: require_once DIR_PROJ_EDITORS_MODELS . $path . '.php'; break;
			}
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
				self::SOURCE_MODEL => "\\Proj\\Models\\{$path}",
				self::SOURCE_EDITORS => "\\Proj\\Editors\\Models\\{$path}",
				default => die('Unexpected match value')
			};
			$this->models[$name] = new $class();
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
		public function regAndGet(string $name, int $source): Model {
			if (!isset($this->models[$name])) $this->registration($name, $source);

			return $this->get($name);
		}

	}