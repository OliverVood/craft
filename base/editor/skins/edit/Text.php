<?php

	namespace Base\Editor\Skins\Edit;

	/**
	 * Скин для отображения текстового поля
	 */
	class Text extends Input {
		public function __construct(string $name, string $title = '') {
			parent::__construct('text', $name, $title);
		}

	}