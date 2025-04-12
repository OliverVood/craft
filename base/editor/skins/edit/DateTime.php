<?php

	namespace Base\Editor\Skins\Edit;

	/**
	 * Скин для отображения поля даты-времени
	 */
	class DateTime extends Input {
		public function __construct(string $name, string $title = '') {
			parent::__construct('datetime-local', $name, $title);
		}

	}