<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Access\Features;
	use Base\Access\Feature;
	use Base\Access\Links;
	use Base\DB\DB;
	use Base\Helper\Response;
	use Base\Link\External;
	use Exception;
	use JetBrains\PhpStorm\NoReturn;
	use stdClass;

	/**
	 * Класс приложения
	 */
	class App {
		use Singleton;

		private Config $config;

		private Request $request;
		private Response $response;

		public Controllers $controllers;
		public Models $models;

		public Access $access;
		public Features $features;

		public DBs $dbs;
		public Links $links;

		public stdClass $params;

		/**
		 * @param string $html - Путь HTML
		 * @param string $xhr - Путь XHR
		 */
		private function __construct(string $html, string $xhr) {
			session_start();

			$this->config = new Config();

			$this->request = new Request($html, $xhr);
			$this->response = new Response();

			$this->controllers = new Controllers();
			$this->models = new Models();

			$this->access = Access::instance();
			$this->features = new Features();

			$this->dbs = new DBs();
			$this->links = new Links();

			$this->params = new stdClass();
		}

		/**
		 * Возвращает объект конфигурации
		 * @return Config
		 */
		public function config(): Config {
			return $this->config;
		}

		/**
		 * Возвращает объект запроса
		 * @return Request
		 */
		public function request(): Request {
			return $this->request;
		}

		/**
		 * Возвращает объект ответов
		 * @return Response
		 */
		public function response(): Response {
			return $this->response;
		}

		/**
		 * Возвращает контроллер по имени
		 * @param string $name - Наименование контроллера
		 * @return Controller
		 */
		public function controllers(string $name): Controller {
			return $this->controllers->registrationAndGet($name, Controllers::SOURCE_CONTROLLERS);
		}

		/**
		 * Возвращает модель по имени
		 * @param string $name - Наименование модели
		 * @return Model
		 */
		public function models(string $name): Model {
			return $this->models->registrationAndGet($name, Models::SOURCE_MODELS);
		}

		/**
		 * Возвращает права пользователя
		 * @return Access
		 */
		public function access(): Access {
			return $this->access;
		}

		/**
		 * Возвращает базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return DB
		 */
		public function db(string $alias): DB {
			return $this->dbs->registrationAndGet($alias);
		}

		/**
		 * Возвращает признак по имени
		 * @param string $name - Наименование признака
		 * @return Feature
		 */
		public function features(string $name): Feature {
			return $this->features->get($name);
		}

		/**
		 * Возвращает версию
		 * @return string
		 */
		public function version(): string {
			return env('APP_VERSION', '1.0.0');
		}

		/**
		 * Выводит ошибку приложения
		 * @param Exception $e - Исключение
		 * @return void
		 */
		#[NoReturn] public function error(Exception $e): void {
			echo $e->getMessage();
			exit;
		}

	}