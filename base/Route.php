<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Маршрут
	 */
	class Route {
		private array $middlewares = [];

		public function __construct(
			private string          $url,
			private readonly string $method,
			private readonly string $handler,
			private readonly int    $source = Controllers::SOURCE_CONTROLLERS
		) {  }

		/**
		 * Возвращает путь маршрута
		 * @return string
		 */
		public function url(): string {
			return $this->url;
		}

		/**
		 * Возвращает метод маршрута
		 * @return string
		 */
		public function method(): string {
			return $this->method;
		}

		/**
		 * Возвращает исполнителя маршрута
		 * @return string
		 */
		public function handler(): string {
			return $this->handler;
		}

		/**
		 * Возвращает источник
		 * @return int
		 */
		public function source(): int {
			return $this->source;
		}

		/**
		 * Возвращает массив промежуточных программных обеспечений
		 * @return array
		 */
		public function middlewares(): array {
			$out = [];
			foreach ($this->middlewares as $name) {
				$out[] = app()->middlewares->registration($name);
			}

			return $out;
		}

		/**
		 * Задаёт заказчика маршрута
		 * @param string $url - Заказчик
		 * @return void
		 */
		public function setUrl(string $url): void {
			$this->url = $url;
		}

		/**
		 * Регистрирует промежуточные программные обеспечения в маршруте
		 * @param string $middlewares - Перечень промежуточных программных обеспечений
		 * @return $this
		 */
		public function middleware(string $middlewares): self {
			$middlewares = explode(' ', $middlewares);

			foreach ($middlewares as $middleware) {
				$this->middlewares[] = $middleware;
			}

			return $this;
		}

	}