<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Statistics;

	use Base\DB\Driver\MySQLi\Request\Select;
	use Base\Editor\Model;
	use stdClass;

	/**
	 * Модель-редактор статистики посещаемости
	 */
	class IPs extends Model {
		public function __construct() {
			parent::__construct('craft', 'statistics_ip');
		}

		/**
		 * Возвращает запрос на выборку данных
		 * @param array ...$fields - Перечень полей
		 * @param stdClass $params - Параметры
		 * @return Select
		 */
		protected function getQuerySelect(array $fields, stdClass $params): Select {
			return $this->db
				->select()
				->fields(...$fields)
				->table($this->table)
				->order('datecr', 'DESC')
				->order('id', 'DESC');
		}

		/**
		 * Возвращает запрос на выборку одной записи
		 * @param int $id - Идентификатор
		 * @param string ...$fields - Перечень полей
		 * @return Select
		 */
		protected function getQueryBrowse(int $id, string ...$fields): Select {
			return $this->db
				->select()
				->fields(...$fields)
				->table($this->table)
				->where('id', $id);
		}

	}