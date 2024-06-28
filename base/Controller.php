<?php

	namespace Base;

	use base\data\set\Input;

	abstract class Controller {
		private static /** @var Controller[] */ array $controllers = [];

		public static function run(string $controller, string $method, Input $input): void {
			if (!isset(self::$controllers[$controller])) {
				self::load($controller);
				self::init($controller);
			}
			call_user_func_array([self::$controllers[$controller], $method], [$input]);
		}

		public static function load(string $controller): void {
			$controllerPath = str_replace('.', '/', $controller);
			require_once DIR_PROJ_CONTROLLERS . $controllerPath . '.php';
		}

		public static function init(string $controller): void {
			$controllerPath = str_replace('.', '\\', $controller);
			$class = "\\proj\\controllers\\{$controllerPath}";
			self::$controllers[$controller] = new $class();
		}

	}