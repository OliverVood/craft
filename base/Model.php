<?php

	namespace Base;

	/**
	 * Базовый класс для работы с моделями
	 */
	abstract class Model {
		private static /** @var Model[] */ array $models = [];

		/**
		 * Возвращает модель
		 * @param $model - Название модели
		 * @return self
		 */
		public static function get($model): self {
			if (!isset(self::$models[$model])) {
				self::load($model);
				self::init($model);
			}
			return self::$models[$model];
		}

		/**
		 * Загружает модель
		 * @param string $models - Название модели
		 * @return void
		 */
		public static function load(string $models): void {
			require_once DIR_PROJ_MODELS . $models . '.php';
		}

		/**
		 * Инициализирует модель
		 * @param string $model - Название модели
		 * @return void
		 */
		public static function init(string $model): void {
			$class = "\\proj\\models\\{$model}";
			self::$models[$model] = new $class();
		}

	}