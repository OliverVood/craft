<?php

	namespace Base\DB\Driver\MySQLi\Request;

	class Update extends \Base\DB\Request\Update {
		use Render;

		/**
		 * Возвращает текст запроса
		 * @return string
		 */
		public function get(): string {
			$table = $this->renderTable();
			$data = $this->renderData();
			$where = $this->renderConditions();

			return "UPDATE {$table} SET {$data}{$where}";
		}

		/**
		 * Возвращает данные для запроса
		 * @return string
		 */
		private function renderData(): string {
			$data = [];
			$fields = $this->renderFields();
			$values = $this->renderValues();
			foreach ($fields as $key => $field) {
				$data[] = "{$field} = {$values[$key]}";
			}
			return implode(', ', $data);
		}

		/**
		 * Возвращает поля
		 * @return array
		 */
		private function renderFields(): array {
			$fields = [];
			foreach ($this->data as $field => $value) $fields[] = $this->shield($field);

			return $fields;
		}

		/**
		 * Возвращает значения
		 * @return array
		 */
		public function renderValues(): array {
			$values = [];
			foreach ($this->data as $value) {
				$values[] = match ($value) {
					null => "NULL",
					default => "'{$this->db->escape($value)}'",
				};
			}

			return $values;
		}

	}