<?php

	declare(strict_types=1);

	namespace Base;

	use Exception;

	/**
	 * Маршруты
	 */
	class Routes {
		use Singleton;

		private array $stack = [];

		private function __construct() {  }

		/**
		 * Регистрирует маршрут
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @param string $method - Метод
		 * @return Route
		 */
		public function registration(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS, string $method = '*'): Route {
			$route = new Route($url, $method, $handler, $source);
			$this->stack[] = $route;

			return $route;
		}

		/**
		 * Регистрирует маршрут с всеми методами
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @return Route
		 */
		public function all(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS): Route {
			return $this->registration($url, $handler, $source);
		}

		/**
		 * Регистрирует маршрут с методом GET
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @return Route
		 */
		public function get(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS): Route {
			return $this->registration($url, $handler, $source, 'get');
		}

		/**
		 * Регистрирует маршрут с методом POST
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @return Route
		 */
		public function post(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS): Route {
			return $this->registration($url, $handler, $source, 'post');
		}

		/**
		 * Регистрирует маршрут с методом PATCH
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @return Route
		 */
		public function patch(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS): Route {
			return $this->registration($url, $handler, $source, 'patch');
		}

		/**
		 * Регистрирует маршрут с методом PUT
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @return Route
		 */
		public function put(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS): Route {
			return $this->registration($url, $handler, $source, 'put');
		}

		/**
		 * Регистрирует маршрут с методом DELETE
		 * @param string $url - Путь
		 * @param string $handler - Обработчик
		 * @param int $source - Источник
		 * @return Route
		 */
		public function delete(string $url, string $handler, int $source = Controllers::SOURCE_CONTROLLERS): Route {
			return $this->registration($url, $handler, $source, 'delete');
		}

		/**
		 * Регистрирует пустой маршрут
		 * @param string $url - Путь
		 * @return Route
		 */
		public function empty(string $url): Route {
			return $this->registration($url, 'empty');
		}

		/**
		 * Регистрирует группу маршрутов
		 * @param string $prefix - Префикс
		 * @param array $routes - Маршруты
		 * @return RouteGroup
		 */
		public function group(string $prefix, array $routes): RouteGroup {
			return new RouteGroup($prefix, $routes);
		}

		/**
		 * Выполняет маршрутизацию
		 * @return void
		 */
		public function run(): void {
			if (!$find = $this->find()) return;

			$source = $find['source'];
			$handler = $find['handler'];
			$middlewares = $find['middlewares'];
			$params = $find['params'];

			if ($handler == 'empty') {
				$this->runOnlyMiddleware($middlewares);
				return;
			}

			if (request()->methodVirtual() != 'get' && !csrfValidate()) app()->error(new Exception('Invalid csrf token'));

			$parts = explode('::', $handler);
			$controller = $parts[0];
			$call = $parts[1] ?? '';

			$this->runController($middlewares, $source, $controller, $call, $params);
		}

		/**
		 * Ищет маршрут
		 * @return array|null
		 */
		private function find(): ?array {
			foreach ($this->stack as /** @var Route $route */ $route) {
				$url = $route->url();
				$method = $route->method();

				[$isFind, $params] = $this->check($url, $method);

				if ($isFind) {
					return [
						'source' => $route->source(),
						'handler' => $route->handler(),
						'middlewares' => $route->middlewares(),
						'params' => $params,
					];
				}
			}

			return null;
		}

		/**
		 * Проверяет маршрут
		 * @param string $url - URL
		 * @param string $method - Метод
		 * @return array
		 */
		private function check(string $url, string $method): array {
			if (!in_array($method, ['*', request()->methodVirtual()])) return [false, null];

			$customer = parse_url($url, PHP_URL_PATH);
			$customers = explode('/', $customer);

			$requestUrl = parse_url(request()->url(), PHP_URL_PATH);
			$urls = explode('/', $requestUrl);

			$params = [];

			$isAll = false;
			foreach ($customers as $key => $value) {
				if ($value == ':(all)') { $isAll = true; break; }
				if (!isset($urls[$key])) return [false, null];

				switch ($value) {
					case ':(num)': $params[] = (int)$urls[$key]; if (!is_numeric($urls[$key])) return [false, null]; break;
					case ':(str)': $params[] = $urls[$key]; if (!is_string($urls[$key])) return [false, null]; break;
					case ':(any)': $params[] = $urls[$key]; break;
					default: if ($value != $urls[$key]) return [false, null]; break;
				}
			}

			if (!$isAll && (count($customers) != count($urls))) return [false, null];

			return [true, $params];
		}

		/**
		 * Запускает только промежуточное программное обеспечение
		 * @param Middleware[] $middlewares - Стек программного обеспечения
		 * @return void
		 */
		private function runOnlyMiddleware(array $middlewares): void {
			$this->runMiddlewaresInlet($middlewares);
			$this->runMiddlewaresOutlet($middlewares);
		}

		/**
		 * Запускает контроллеры с промежуточным программным обеспечением
		 * @param Middleware[] $middlewares - Стек программного обеспечения
		 * @param int $source - Источник
		 * @param string $controller - Контроллер
		 * @param string $call - Метод
		 * @param array $params - Параметры из строки запроса
		 * @return void
		 */
		private function runController(array $middlewares, int $source, string $controller, string $call, array $params): void {
			$this->runMiddlewaresInlet($middlewares);
			app()->controllers->run($source, $controller, $call, $params);
			$this->runMiddlewaresOutlet($middlewares);
		}

		/**
		 * Запускает стек программного обеспечения на вход
		 * @param Middleware[] $middlewares - Стек программного обеспечения
		 * @return void
		 */
		private function runMiddlewaresInlet(array $middlewares): void {
			foreach ($middlewares as $middleware) $middleware->inlet();
		}

		/**
		 * Запускает стек программного обеспечения на выход
		 * @param Middleware[] $middlewares - Стек программного обеспечения
		 * @return void
		 */
		private function runMiddlewaresOutlet(array $middlewares): void {
			foreach (array_reverse($middlewares) as $middleware) $middleware->outlet();
		}

	}