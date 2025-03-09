<?php

	declare(strict_types=1);

	namespace Base\Link;

	/**
	 * Работа с внутренними ссылками
	 */
	class Internal extends External {
		private string $entity;
		private string $action;

		private string $path;
		private string $href;
		private string $xhr;

		public function __construct(string $entity = '*', string $action = '*', string $href = '', string $click = '') {
			parent::__construct('', $click);
			$this->entity = $entity;
			$this->action = $action;

			$this->path = '';

			if ($this->entity !== '*' && $this->entity !== '') $this->path .= "/{$this->entity}";
			if ($this->action !== '*' && $this->action !== '') $this->path .= "/{$this->action}";

			if ($href == 'default') {
				$this->href 	= request()->html() . $this->path;
				$this->xhr 		= request()->xhr() . $this->path;
				$this->address 	= request()->address() . request()->html() . $this->path;
			} else {
				$this->href 	= request()->html() . $href;
				$this->xhr		= request()->xhr() . $href;
				$this->address	= request()->address() . request()->html() . $href;
			}
		}

		/**
		 * Возвращает путь
		 * @return string
		 */
		public function path(): string {
			return $this->path;
		}

		/**
		 * Возвращает href
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function href(array $data = []): string {
			return $this->ParseTarget($this->href ?: '/', $data);
		}

		/**
		 * Возвращает ссылку anchor
		 * @param string $content - Контент
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function linkHref(string $content, array $data = [], array $params = []): string {
			return $this->link($this->href($data), $content, $data, $params);
		}

		/**
		 * Возвращает xhr
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function xhr(array $data = []): string {
			return $this->ParseTarget($this->xhr, $data);
		}

		/**
		 * Возвращает ссылку anchor xhr
		 * @param string $content - Контент
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function linkXHR(string $content, array $data = [], array $params = []): string {
			return $this->link($this->xhr($data), $content, $data, $params);
		}

	}