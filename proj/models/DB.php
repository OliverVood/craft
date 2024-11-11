<?php

	namespace Proj\Models;

	use Base\Model;

	/**
	 * Модель базы данных
	 */
	class DB extends Model {
		private \Base\DB\DB $db;

		public function __construct() {
			$this->db = \Proj\DB\Craft::instance();
		}

		/**
		 * Возвращает структуры базы данных
		 * @return array
		 */
		public function structure(): array {
			require DIR_ENTRY_ADMIN . 'structures.php';

			return $this->db->structure->get();
		}

		/**
		 * Проверяет структуру базы данных
		 * @return array
		 */
		public function check(): array {
			require DIR_ENTRY_ADMIN . 'structures.php';

			return $this->db->structure->check();
		}

		/**
		 * Исправляет структуру базы данных
		 * @param array $data - Данные
		 * @return bool
		 */
		public function make(array $data): bool {
			require DIR_ENTRY_ADMIN . 'structures.php';

			return $this->db->structure->make($data);
		}

	}