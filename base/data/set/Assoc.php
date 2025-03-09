<?php

	namespace Base\Data\Set;

	/**
	 * Хранение пользовательских данных из контента в виде ассоциативного массива
	 */
	class Assoc extends Base {
		public function __construct() {
			parent::__construct(json_decode(file_get_contents("php://input"), true) ?? []);
		}

	}