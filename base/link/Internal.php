<?php

	declare(strict_types=1);

	namespace Base\Link;

	/**
	 * Класс внутренних ссылок
	 */
	class Internal extends Fundamental {
		private string $path;

		private string $href;
		private string $xhr;

		public function __construct(string $path = '', string $click = '') {
			$this->path = $path;

			$this->href 	= request()->html() . $path;
			$this->xhr		= request()->xhr() . $path;

			parent::__construct(request()->address() . request()->html() . $path, $click);
		}

		/**
		 * Возвращает путь
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function path(array $data = []): string {
			return $this->prepare($this->path/* ?: '/'*/, $data);
		}

		/**
		 * Возвращает href
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function href(array $data = []): string {
			return $this->prepare($this->href, $data);
		}

		/**
		 * Возвращает xhr
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function xhr(array $data = []): string {
			return $this->prepare($this->xhr, $data);
		}

		/**
		 * Возвращает гиперссылку href
		 * @param string $content - Содержимое
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function hyperlinkHref(string $content, array $data = [], array $params = []): string {
			$params['href'] = $this->href;
			return $this->hyperlink($content, $data, $params);
		}

		/**
		 * Возвращает гиперссылку xhr
		 * @param string $content - Содержимое
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function hyperlinkXHR(string $content, array $data = [], array $params = []): string {
			$params['href'] = $this->xhr;
			return $this->hyperlink($content, $data, $params);
		}

	}