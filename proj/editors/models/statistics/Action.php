<?php

	namespace Proj\Editors\Models\Statistic;

	use Base\DB\Driver\MySQLi\Request\Select;
	use Base\Editor\Model;

	/**
	 * Модель статистики деятельности пользователей
	 */
	class Action extends Model {
		public function __construct() {
			parent::__construct('statistics_act');
		}

		/**
		 * Возвращает запрос на выборку данных
		 * @param string ...$fields - Перечень полей
		 * @return Select
		 */
		protected function getQuerySelect(string ...$fields): Select {
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