<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Data\Set;

	/**
	 * Класс для работы с запросом
	 */
	class Request {
		private string $protocol;
		private string $host;
		private string $urlBase;
		private string $url;
		private string $method;
		private string $methodVirtual;

		private ?string $timezone;
		private string $clientIP;

		private string $html;
		private string $xhr;

		private Set $data;

		public function __construct(string $html, string $xhr) {
			$this->protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
			$this->host = $_SERVER['SERVER_NAME'];
			$this->url = "{$this->protocol}://{$this->host}{$_SERVER['REQUEST_URI']}";
			$this->urlBase = explode('?', $this->url)[0];
			$this->method = strtolower($_SERVER['REQUEST_METHOD']);

			$this->timezone = $_COOKIE['timezone'] ?? null;
			$this->clientIP = $this->getClientIP();

			$this->html = $html;
			$this->xhr = $xhr;

			$this->data = new Set();

			$__method = $this->data->defined('__method')->string('-');
			$this->methodVirtual = in_array($__method, ['get', 'post', 'put', 'patch', 'delete']) ? $__method : $this->method;
		}

		/**
		 * Возвращает протокол
		 * @return string
		 */
		public function protocol(): string {
			return $this->protocol;
		}

		/**
		 * Возвращает имя хоста
		 * @return string
		 */
		public function host(): string {
			return $this->host;
		}

		/**
		 * Возвращает URL
		 * @return string
		 */
		public function url(): string {
			return $this->url;
		}

		/**
		 * Возвращает базовый (без параметров) URL
		 * @return string
		 */
		public function urlBase(): string {
			return $this->urlBase;
		}

		/**
		 * Возвращает метод запроса
		 * @return string
		 */
		public function method(): string {
			return $this->method;
		}

		/**
		 * Возвращает виртуальный метод запроса
		 * @return string
		 */
		public function methodVirtual(): string {
			return $this->methodVirtual;
		}

		/**
		 * Возвращает часовой пояс клиента
		 * @return string|null
		 */
		public function timezone(): ?string {
			return $this->timezone;
		}

		/**
		 * Возвращает IP клиента
		 * @return string
		 */
		public function clientIP(): string {
			return $this->clientIP;
		}

		/**
		 * Возвращает адрес
		 * @return string
		 */
		public function address(): string {
			return "{$this->protocol}://{$this->host}";
		}

		/**
		 * Возвращает относительный путь для точки входа html
		 * @return string
		 */
		public function html(): string {
			return $this->html;
		}

		/**
		 * Возвращает относительный путь для точки входа xhr
		 * @return string
		 */
		public function xhr(): string {
			return $this->xhr;
		}

		/**
		 * Возвращает объект с данными запроса
		 * @return Set
		 */
		public function data(): Set {
			return $this->data;
		}

		/**
		 * Получает IP клиента
		 * @return string
		 */
		function getClientIP(): string {
			$client = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote = @$_SERVER['REMOTE_ADDR'];

			if (filter_var($client, FILTER_VALIDATE_IP)) return $client;
			else if (filter_var($forward, FILTER_VALIDATE_IP)) return $forward;
			else return $remote;
		}

	}