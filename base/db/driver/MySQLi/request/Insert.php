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
			$values = $this->renderValuesArray();

			return "INSERT INTO {$table} ({$fields}) VALUES {$values}";
		}

		/**
		 * Возвращает поля
		 * @return string
		 */
		private function renderFields(): string {
			$fields = [];
			foreach ($this->fields as $field) $fields[] = $this->shield($field);

			return implode(', ', $fields);
		}

		/**
		 * Возвращает значения
		 * @param array $data - Данные
		 * @return string
		 */
		private function renderValues(array $data): string {
			$values = [];
			foreach ($data as $value) {
				$values[] = match ($value) {
					null => "NULL",
					default => "'{$this->db->escape($value)}'",
				};
			}

			return '(' . implode(', ', $values) . ')';
		}

		/**
		 * Возвращает перечень значений
		 * @return string
		 */
		private function renderValuesArray(): string {
			$values = [];
			foreach ($this->data as $data) {
				$values[] = $this->renderValues($data);
			}

			return implode(', ', $values);
		}

	}