<?php

	declare(strict_types=1);

	namespace Proj\Models;

	use Base\DB\DB;
	use Base\Model;

	/**
	 * Модель новостей
	 */
	class News extends Model {
		const TABLE_NEWS = 'news';

		const STATE_ERROR = 0;
		const STATE_ACTIVE = 1;
		const STATE_INACTIVE = 2;
		const STATE_DRAFT = 5;
		const STATE_DELETE = 100;

		const PATH_COVER_RELATIVE = DIR_RELATIVE_IMAGE . 'news/';

		private DB $db;

		public function __construct() {
			parent::__construct();

			$this->db = app()->db('craft');
		}

		/**
		 * Возвращает $count последних опубликованных новостей
		 * @param int|null $count - Данные
		 * @return array
		 */
		public function all(?int $count = null): array {
			$response = $this->db
				->select()
				->table(self::TABLE_NEWS)
				->fields('id', 'datecr', 'header', 'content', 'hash', 'ext')
				->where('state', self::STATE_ACTIVE)
				->compareFunc('datepb', 'NOW()', '<')
				->order('datepb', 'DESC')
				->order('id')
				->limit($count)
				->query();

			$data = [];

			foreach ($response->each() as $row) {
				$row['cover'] = self::PATH_COVER_RELATIVE . "{$row['hash']}.{$row['id']}.{$row['ext']}";
				$data[] = $row;
			}

			return $data;
		}

		/**
		 * Возвращает новость по идентификатору
		 * @param int $id - Идентификатор
		 * @return array|null
		 */
		public function get(int $id): ?array {
			$response = $this->db
				->select()
				->table(self::TABLE_NEWS)
				->fields('id', 'datecr', 'datepb', 'header', 'content', 'hash', 'ext')
				->where('id', $id)
				->where('state', self::STATE_ACTIVE)
				->compareFunc('datepb', 'NOW()', '<')
				->limit(1)
				->query();

			if (!$row = $response->get()) return null;

			$row['cover'] = self::PATH_COVER_RELATIVE . "{$row['hash']}.{$row['id']}.{$row['ext']}";

			return $row;
		}

	}