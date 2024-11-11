<?php

	namespace Base\Data\Set;

	use stdClass;

	/**
	 * Хранение пользовательских данных из контента
	 */
	class Content {
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