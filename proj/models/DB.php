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

		public function structure(): array {
			require DIR_ENTRY_ADMIN . 'structures.php';

			return $this->db->structure->get();
		}
	}