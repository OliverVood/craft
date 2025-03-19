<?php

	declare(strict_types=1);

	namespace Base\Data;

	use stdClass;

	/**
	 * Хранение пользовательских данных из контента
	 */
	class Input {
		private stdClass $data;

		public function __construct() {
			$this->data = json_decode(file_get_contents("php://input"), false) ?? new stdClass();
		}

		/**
		 * Возвращает значение
		 * @return stdClass
		 */
		public function data(): stdClass {
			return $this->data;
		}

	}