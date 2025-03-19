<?php

	declare(strict_types=1);

	namespace Base\Data;

	/**
	 * Хранение пользовательских данных из контента в виде ассоциативного массива
	 */
	class InputArray extends Base {
		public function __construct() {
			parent::__construct(json_decode(file_get_contents("php://input"), true) ?? []);
		}

	}