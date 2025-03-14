<?php

	namespace Base\Data;

	/**
	 * Хранение пользовательских данных от предыдущего запроса
	 */
	class Old extends Base {
		public function __construct() {
			parent::__construct($_SESSION['__old'] ?? []);
		}

	}