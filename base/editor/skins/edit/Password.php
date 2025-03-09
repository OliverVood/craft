<?php

	namespace Base\Editor\Skins\Edit;

	/**
	 * Скин для отображения текстового поля
	 */
	class Password extends Input {
		public function __construct(string $name, string $title = '') {
			parent::__construct('password', $name, $title);
		}

	}