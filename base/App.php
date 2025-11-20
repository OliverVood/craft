<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Access\Links;
	use Base\DB\DB;
	use Base\Helper\Response;
	use Base\Helper\Security;
	use Exception;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\UI\Templates;
	use stdClass;

	/**
	 * Приложение
	 */
	class App {
		use Singleton;

		private Request $request;
		private Response $response;

		public Controllers $controllers;
		public Middlewares $middlewares;
		public Models $models;

		public DBs $dbs;

		public stdClass $params;

		private string $csrf;
		private string $versionDevelopment;

		/**
		 * @param string $html - Путь HTML
		 * @param string $xhr - Путь XHR
		 */
		private function __construct(string $html, string $xhr) {
			session()->start();

			$this->csrf = Security::csrf();
			$this->versionDevelopment = 'dev_' . time();

			$this->request = new Request($html, $xhr);
			$this->response = new Response();

			$this->controllers = new Controllers();
			$this->middlewares = new Middlewares();
			$this->models = new Models();

			$this->dbs = new DBs();

			$this->params = new stdClass();
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
		 * Возвращает базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return DB
		 */
		public function db(string $alias): DB {
			return $this->dbs->registrationAndGet($alias);
		}

		/**
		 * Возвращает CSRF
		 * @return string
		 */
		public function csrf(): string {
			return $this->csrf;
		}

		/**
		 * Возвращает версию
		 * @return string
		 */
		public function version(): string {
			if (env('APP_ASSEMBLY', 'production') == 'development') return $this->versionDevelopment;

			return env('APP_VERSION', '1.0.0');
		}

		/**
		 * Выводит ошибку приложения
		 * @param Exception $e - Исключение
		 * @return void
		 */
		#[NoReturn] public function error(Exception $e): void {
			/** @var Templates\Error $template */ $template = template('error');

			$template->layout->main->push('<h1>The <b>Craft</b> app has encountered a critical error.</h1>');
			$template->layout->main->push('<h3>Message:</h3>');
			$template->layout->main->push('<div class = "error">' . $e->getMessage(). '</div>');

			$template->browse(true);
		}

	}