<?php

	namespace Base\DB\Driver\MySQLi\Request;

	class Delete extends \Base\DB\Request\Delete {
		use Render;

		/**
		 * Возвращает текст запроса
		 * @return string
		 */
		public function get(): string {
			$table = $this->renderTable();
			$where = $this->renderConditions();

			return "DELETE FROM {$table}{$where}";
		}

	}