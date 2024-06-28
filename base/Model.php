<?php

	namespace Base;

	abstract class Model {
		private static /** @var Model[] */ array $models = [];

		public static function get($model): self {
			if (!isset(self::$models[$model])) {
				self::load($model);
				self::init($model);
			}
			return self::$models[$model];
		}

		public static function load(string $models): void {
			require_once DIR_PROJ_MODELS . $models . '.php';
		}

		public static function init(string $model): void {
			$class = "\\proj\\models\\{$model}";
			self::$models[$model] = new $class();
		}

	}