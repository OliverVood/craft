<?php

	declare(strict_types=1);

	namespace Proj\Models;

	use Base\DB\DB;
	use Base\Model;

	/**
	 * Пользовательская модель
	 */
	class Feedback extends Model {
		const TABLE_FEEDBACK = 'feedback';

		const STATE_NEW						= 1;
		const STATE_DONE					= 2;

		private DB $db;

		public function __construct() {
			parent::__construct();

			$this->db = app()->db('craft');
		}

		/**
		 * Добавляет обратную связь
		 * @param array $data - Данные
		 * @return bool
		 */
		public function create(array $data): bool {
			$this->db
				->insert()
				->table(self::TABLE_FEEDBACK)
				->values($data)
				->query();

			return true;
		}

	}