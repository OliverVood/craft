<?php

	namespace Base;

	/**
	 * Базовый класс для работы с моделями
	 */
	abstract class Model {
		const SOURCE_MODEL = 1;
		const SOURCE_EDITORS = 2;

		private static /** @var Model[] */ array $models = [];

		protected function __construct() {  }

		/**
		 * Возвращает модель
		 * @param $model - Название модели
		 * @param int $source - Источник
		 * @return self
		 */
		public static function get(string $model, int $source = self::SOURCE_MODEL): self {
			if (!isset(self::$models[$model])) {
				self::load($model, $source);
				self::init($model, $source);
			}
			return self::$models[$model];
		}

		/**
		 * Загружает модель
		 * @param string $model - Название модели
		 * @param int $source - Источник
		 * @return void
		 */
		public static function load(string $model, int $source): void {
			$controllerPath = str_replace('.', '/', $model);
			switch ($source) {
				case self::SOURCE_MODEL: require_once DIR_PROJ_MODELS . $controllerPath . '.php'; break;
				case self::SOURCE_EDITORS: require_once DIR_PROJ_EDITORS_MODELS . $controllerPath . '.php'; break;
			}
		}

		/**
		 * Инициализирует модель
		 * @param string $model - Название модели
		 * @param int $source - Источник
		 * @return void
		 */
		public static function init(string $model, int $source): void {
			$controllerPath = str_replace('.', '\\', $model);
			$class = match ($source) {
				self::SOURCE_MODEL => "\\Proj\\Models\\{$controllerPath}",
				self::SOURCE_EDITORS => "\\Proj\\Editors\\Models\\{$controllerPath}",
				default => die('Unexpected match value')
			};
			self::$models[$model] = new $class();
		}

	}