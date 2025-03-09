<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Data\Set\Data;

	/**
	 * Класс для работы с запросом
	 */
	class Request {
		private string $protocol;
		private string $host;

		private string $html;
		private string $xhr;

		private Data $data;

		public function __construct(string $html, string $xhr) {
			$this->protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
			$this->host = $_SERVER['SERVER_NAME'];

			$this->html = $html;
			$this->xhr = $xhr;

			$this->data = new Data();
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
		 * @return Data
		 */
		public function data(): Data {
			return $this->data;
		}

	}