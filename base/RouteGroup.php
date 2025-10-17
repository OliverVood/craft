<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Группа маршрутов
	 */
	class RouteGroup {
		private array /** @var Route[] $routes */ $routes = [];

		/**
		 * @param string $prefix - Префикс
		 * @param (Route|RouteGroup)[] $routes - Маршруты
		 */
		public function __construct(string $prefix, array /** @var (Route|RouteGroup)[] $routes */ $routes) {
			foreach ($routes as $route) {
				switch ($route::class) {
					case Route::class: $this->routes[] = $route; break;
					case RouteGroup::class: $this->routes = array_merge($this->routes, $route->routes()); break;
				}
			}

			foreach ($this->routes as $route) {
				$route->setUrl($prefix . $route->url());
			}
		}

		/**
		 * Возвращает маршруты в группе
		 * @return array
		 */
		public function routes(): array {
			return $this->routes;
		}

		/**
		 * Регистрирует промежуточные программные обеспечения в маршрутах группы
		 * @param string $middlewares - Перечень промежуточных программных обеспечений
		 * @return $this
		 */
		public function middleware(string $middlewares): self {
			foreach ($this->routes as /** @var Route $route */ $route) {
				$route->middleware($middlewares);
			}

			return $this;
		}

	}