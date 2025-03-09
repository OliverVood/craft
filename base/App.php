<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Access\Features;
	use Base\Access\Feature;
	use Base\Access\Links;
	use Base\DB\DB;
	use Base\Link\External;

	/**
	 * Класс приложения
	 */
	class App {
		use Instance;

		const ASSEMBLY_PRODUCTION = 1;
		const ASSEMBLY_DEVELOPMENT = 2;

		private Request $request;

		public Controllers $controllers;
		public Models $models;
		public DBs $dbs;
		public Features $features;
		public Links $links;

		private string $version;
		private int $assembly;

		/**
		 * @param string $version - Версия
		 * @param int $assembly - Сборка
		 * @param string $html - Путь HTML
		 * @param string $xhr - Путь XHR
		 */
		private function __construct(string $version, int $assembly, string $html, string $xhr) {
			$this->request = new Request($html, $xhr);
			$this->controllers = new Controllers();
			$this->models = new Models();
			$this->dbs = new DBs();
			$this->features = new Features();
			$this->links = new Links();

			$this->version = $version;
			$this->assembly = $assembly;

			session_start();
		}

		/**
		 * Возвращает объект запроса
		 * @return Request
		 */
		public function request(): Request {
			return $this->request;
		}

		/**
		 * Возвращает контроллер по имени
		 * @param string $name - Наименование контроллера
		 * @return Controller
		 */
		public function controllers(string $name): Controller {
			return $this->controllers->regAndGet($name, Controllers::SOURCE_CONTROLLERS);
		}

		/**
		 * Возвращает модель по имени
		 * @param string $name - Наименование модели
		 * @return Model
		 */
		public function models(string $name): Model {
			return $this->models->regAndGet($name, Models::SOURCE_MODEL);
		}

		/**
		 * Возвращает базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return DB
		 */
		public function db(string $alias): DB {
			return $this->dbs->initAndGet($alias);
		}

		/**
		 * Возвращает признак по имени
		 * @param string $name - Наименование признака
		 * @return Feature
		 */
		public function features(string $name): Feature {
			return $this->features->get($name);
		}

	}