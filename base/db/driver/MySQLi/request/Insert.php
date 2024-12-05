<?php

	namespace Base\DB\Driver\MySQLi\Request;

	class Insert extends \Base\DB\Request\Insert {
		use Render;

		/**
		 * Возвращает текст запроса
		 * @return string
		 */
		public function get(): string {
			$table = $this->renderTable();
			$fields = $this->renderFields();
			$values = $this->renderValues();

			return "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
		}

		/**
		 * Возвращает поля
		 * @return string
		 */
		private function renderFields(): string {
			$fields = [];
			foreach ($this->data as $field => $value) $fields[] = $this->shield($field);

			return implode(', ', $fields);
		}

		/**
		 * Возвращает значения
		 * @return string
		 */
		public function renderValues(): string {
			$values = [];
			foreach ($this->data as $value) {
				$values[] = match ($value) {
					null => "NULL",
					default => "'{$this->db->escape($value)}'",
				};
			}

			return implode(', ', $values);
		}

	}