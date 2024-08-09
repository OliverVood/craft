<?php

	namespace Base\DB\Driver\MySQLi\Request;

	class Select extends \Base\DB\Request\Select {
//		public function join(string $join, string $table, string $as = '', string $on = ''): self;

//		public function calc(...$strings): self;

//		public function group(...$fields): self;
//		public function order(string $field, string $direction = 'ASC', $escape = true): self;
//		public function limit(int $value_1, int $value_2 = null): self;

		/**
		 * Возвращает текст запроса
		 * @return string
		 */
		public function get(): string {
			$fields = $this->renderFields();
			$table = $this->renderTable();
			$where = $this->renderConditions();

//			$limit = '';
//			if (!is_null($this->limit[0])) $limit .= " LIMIT {$this->limit[0]}";
//			if (!is_null($this->limit[1])) $limit .= ", {$this->limit[1]}";
//
//			$order = '';
//			if ($this->order) {
//				$order = []; foreach ($this->order as [$field, $direction, $escape]) $order[] = $escape ? "`{$field}` {$direction}" : "{$field} {$direction}";
//				$order = ' ORDER BY ' . implode(', ', $order);
//			}
//
//			$group = $this->group ? ' GROUP BY `' . implode('`, `', $this->group) . '`' : '';
//
//			return "SELECT {$fields} FROM `{$this->table}`{$this->as}{$this->join}{$where}{$order}{$group}{$limit}";
			return "SELECT {$fields} FROM {$table}{$where}";
//			return 'SELECT 1 as `f1`, 2 as `f2`';
		}

		/**
		 * Возвращает таблицу
		 * @return string
		 */
		private function renderTable(): string {
			return $this->shield($this->table);
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

//		public function join(string $table, string $join = 'LEFT JOIN', string $as = '', string $on = ''): self {
//			$as = " `{$as}`";
//			$this->join = " {$join} `{$table}` `{$as}` ON ({$on})";
//			return $this;
//		}

		/**
		 * Возвращает условия
		 * @return string
		 */
		private function renderConditions(): string {
			$list = [];
			$first = true;

			foreach ($this->conditions as $condition) {
				$connection = $first ? '' : " {$condition['connection']} ";
				$data = $condition['data'];
				switch ($condition['type']) {
					case 'where': $list[] = "{$connection}{$this->shield($data['field'])} {$data['operator']} '{$data['value']}'"; break;
					case 'compare': $list[] = "{$connection}{$this->shield($data['field1'])} {$data['operator']} {$this->shield($data['field2'])}"; break;
				}
				$first = false;
			}

			return $list ? ' WHERE ' . implode('', $list) : '';
		}

		/**
		 * Возвращает экранированные названий: баз данных, таблиц, полей
		 * @param string $str - Строка для экранирования
		 * @return string
		 */
		private function shield(string $str): string {
			$matchs = [];
			preg_match('/ *([^ ]*)( +(as +)?([^ ]*))? */', $str, $matchs);
			$name = $matchs[1];
			$as = $matchs[4] ?? null;

			$out = '`' . implode('`.`', explode('.', $name)) . '`';
			if ($as) $out .= " AS `{$as}`";

			return $out;
		}

	}