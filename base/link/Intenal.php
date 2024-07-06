<?php

	namespace Base\Link;

	/**
	 * Работа со ссылками
	 */
	class Intenal extends External {
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

			if ($this->entity !== '*') $this->path .= "/{$this->entity}";
			if ($this->action !== '*') $this->path .= "/{$this->action}";

			if ($href == 'default') {
				$this->href 	= REQUEST . $this->path;
				$this->xhr 		= XHR . $this->path;
				$this->address 	= ADDRESS . REQUEST . $this->path;
			} else {
				$this->href 	= REQUEST . $href;
				$this->xhr		= XHR . $href;
				$this->address	= ADDRESS . REQUEST . $href;
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

	}