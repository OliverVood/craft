<?php

	declare(strict_types=1);

	namespace Proj\Models;

	use Base\DB\DB;
	use Base\Model;

	/**
	 * Модель новостей изменений на сайте
	 */
	class Changes extends Model {
		const TABLE_CHANGES = 'changes';
		const TABLE_CHANGE = 'change';

		const STATE_ERROR = 0;
		const STATE_ACTIVE = 1;
		const STATE_INACTIVE = 2;
		const STATE_DRAFT = 5;
		const STATE_DELETE = 100;

		const PATH_COVER_RELATIVE = DIR_RELATIVE_IMAGE . 'changes/';

		private DB $db;

		public function __construct() {
			parent::__construct();

			$this->db = app()->db('craft');
		}

		/**
		 * Возвращает $count последних изменений на сайте
		 * @param int|null $count - Данные
		 * @return array
		 */
		public function all(?int $count = null): array {
			$response = $this->db
				->select()
				->table(self::TABLE_CHANGES)
				->fields('id', 'header')
				->where('state', self::STATE_ACTIVE)
				->compareFunc('datepb', 'NOW()', '<')
				->order('datepb', 'DESC')
				->order('id')
				->limit($count)
				->query();

			return $response->all();
		}

		/**
		 * Возвращает изменение на сайте по идентификатору
		 * @param int $id - Идентификатор
		 * @return array|null
		 */
		public function get(int $id): ?array {
			$response = $this->db
				->select()
				->table(self::TABLE_CHANGES)
				->fields('id', 'header', 'datepb')
				->where('id', $id)
				->where('state', self::STATE_ACTIVE)
				->compareFunc('datepb', 'NOW()', '<')
				->limit(1)
				->query();

			return $response->get();
		}

		/**
		 * Возвращает содержимое изменения
		 * @param int $id - Идентификатор изменения
		 * @return array
		 */
		public function content(int $id): array {
			$response = $this->db
				->select()
				->table(self::TABLE_CHANGE)
				->fields('header', 'content', 'hash', 'id', 'ext')
				->where('state', self::STATE_ACTIVE)
				->where('cid', $id)
				->order('id')
				->query();

			$data = [];

			foreach ($response->each() as $row) {
				$row['cover'] = self::PATH_COVER_RELATIVE . "{$row['hash']}.{$row['id']}.{$row['ext']}";
				$data[] = $row;
			}

			return $data;
		}

	}