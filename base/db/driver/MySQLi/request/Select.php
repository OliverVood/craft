<?php

	namespace Base\DB\Driver\MySQLi\Request;

	class Select extends \Base\DB\Request\Select {
		use Render;

		/**
		 * Возвращает текст запроса
		 * @return string
		 */
		public function get(): string {
			$fields = $this->renderFields();
			$table = $this->renderTable();
			$joins = $this->renderJoins();
			$where = $this->renderConditions();
			$order = $this->renderOrder();
//			$group = $this->group ? ' GROUP BY `' . implode('`, `', $this->group) . '`' : '';
			$limit = $this->renderLimit();

//			return "SELECT {$fields} FROM `{$this->table}`{$this->as}{$this->join}{$where}{$order}{$group}{$limit}";
			return "SELECT {$fields} FROM {$table}{$joins}{$where}{$order}{$limit}";
		}

		/**
		 * Возвращает поля
		 * @return string
		 */
		private function renderFields(): string {
			$fields = [];
			foreach ($this->fields as $field) $fields[] = $field == '*' ? $field : $this->shield($field);
//			foreach ($this->calc as $string) $fields[] = $string;

			return implode(', ', $fields);
		}

		/**
		 * Возвращает объединение таблиц
		 * @return string
		 */
		public function renderJoins(): string {
			$joins = [];
			foreach ($this->joins as ['type' => $type, 'table' => $table, 'on' => $on]) {

				$on = explode('=', $on);
				$on = "{$this->shield($on[0])} = {$this->shield($on[1])}";

				$joins[] = " {$type} JOIN {$this->shield($table)} ON ({$on})";
			}

			return $joins ? implode('', $joins) : '';
		}

		/**
		 * Возвращает сортировку
		 * @return string
		 */
		private function renderOrder(): string {
			if (!$this->order) return '';

			$order = [];
			foreach ($this->order as [$field, $direction]) {
				$order[] = "{$this->shield($field)} {$direction}";
			}

			return ' ORDER BY ' . implode(', ', $order);
		}

		/**
		 * Возвращает ограничения
		 * @return string
		 */
		private function renderLimit(): string {
			$limit = '';
			if (!is_null($this->limit[0])) $limit .= " LIMIT {$this->limit[0]}";
			if (!is_null($this->limit[1])) $limit .= ", {$this->limit[1]}";

			return $limit;
		}

	}