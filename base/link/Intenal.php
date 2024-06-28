<?php

	namespace Base\Link;

	class Intenal extends External {
		private string $entity;
		private string $action;

		private string $path;

		public function __construct(string $entity = '*', string $action = '*', string $href = '', string $click = '') {
			$this->entity = $entity;
			$this->action = $action;

			$this->path = '';

			if ($this->entity !== '*') $this->path .= "/{$this->entity}";
			if ($this->action !== '*') $this->path .= "/{$this->action}";
		}

		/**
		 * Возвращает путь
		 * @return string
		 */
		public function path(): string {
			return $this->path;
		}

	}