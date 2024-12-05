<?php

	namespace Base\Data\Set;

	/**
	 * Хранение пользовательских данных от предыдущего запроса
	 */
	class Old extends Data {
		public function __construct() {
			parent::__construct($_SESSION['__old'] ?? []);
		}

	}