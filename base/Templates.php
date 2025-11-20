<?php

	declare(strict_types=1);

	namespace Base;

	use Base\UI\Template;
	use Exception;

	/**
	 * Шаблоны
	 */
	class Templates {
		use Singleton;
		private array $templates = [];

		/**
		 * Регистрирует шаблон
		 * @param string $name - Наименование шаблона
		 * @return void
		 */
		private function registration(string $name): void {
			$this->load($name);
			$this->init($name);
		}

		/**
		 * Загружает шаблон
		 * @param string $name - Наименование шаблона
		 * @return void
		 */
		public function load(string $name): void {
			$path = str_replace('.', '/', $name);
			$file = DIR_PROJ_TEMPLATES . $path . '.php';

			if (!file_exists($file)) app()->error(new Exception('Template not found'));

			require_once $file;
		}

		/**
		 * Инициализирует шаблон
		 * @param string $name - Наименование шаблона
		 * @return void
		 */
		private function init(string $name): void {
			$path = str_replace('.', '\\', $name);
			$class = "\\Proj\\UI\\Templates\\{$path}";

			if (!class_exists($class)) app()->error(new Exception('Template not found'));

			$this->templates[$name] = new $class();
		}

		/**
		 * Возвращает базу данных по псевдониму
		 * @param string $alias - Псевдоним базы данных
		 * @return Template
		 */
		private function get(string $alias): Template {
			return $this->templates[$alias];
		}

		/**
		 * Регистрирует и возвращает базу данных
		 * @param string $name - Псевдоним базы данных
		 * @return Template
		 */
		public function registrationAndGet(string $name): Template {
			if (!isset($this->templates[$name])) $this->registration($name);

			return $this->get($name);
		}

	}