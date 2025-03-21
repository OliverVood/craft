<?php

	declare(strict_types=1);

	namespace Base\Data;

	/**
	 * Хранение пользовательских данных из объединённых суперглобальных массивов $_POST и $_GET
	 */
	class Defined extends Base {
		public function __construct() {
			parent::__construct(array_merge($_GET, $_POST, json_decode(file_get_contents("php://input"), true) ?? []));
		}

	}