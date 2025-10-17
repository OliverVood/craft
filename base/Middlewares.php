<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Промежуточные программные обеспечения для маршрутизаторов
	 */
	class Middlewares {
		/**
		 * Регистрирует промежуточное программное обеспечение
		 * @param string $name - Наименование промежуточного программного обеспечения
		 * @return Middleware
		 */
		public function registration(string $name): Middleware {
			$this->load($name);
			return $this->init($name);
		}

		/**
		 * Загружает промежуточное программное обеспечение
		 * @param string $name - Наименование промежуточного программного обеспечения
		 * @return void
		 */
		private function load(string $name): void {
			$path = str_replace('.', '/', $name);
			require_once DIR_PROJ_MIDDLEWARES . $path . '.php';
		}

		/**
		 * Инициализирует промежуточное программное обеспечение
		 * @param string $name - Наименование промежуточного программного обеспечения
		 * @return Middleware
		 */
		private function init(string $name): Middleware {
			$path = str_replace('.', '\\', $name);
			$class = "\\Proj\\Middlewares\\{$path}";
			return new $class();
		}

	}