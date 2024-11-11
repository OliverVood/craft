<?php

	namespace Base\DB\Driver\MySQLi;

	/**
	 * Для работы со структурой базы данных mysqli
	 */
	class Structure extends \Base\DB\Structure {

		/**
		 * Создаёт таблицу и добавляет её в структуру
		 * @param string $name - Наименование таблицы
		 * @param string $description - Описание
		 * @return Table
		 */
		public function table(string $name, string $description = ''): Table {
			$this->tables[$name] = new Table($this->db, $name, $description);

			return $this->tables[$name];
		}

		/**
		 * Возвращает имена таблиц в базе данных
		 * @return array
		 */
		protected function getTablesDB(): array {
			$response = $this->db
				->select()
				->table('INFORMATION_SCHEMA.TABLES')
				->fields('table_name name')
				->where('TABLE_SCHEMA', $this->name)
				->query();

			$out = []; foreach ($response->each() as $row) $out[] = $row['name'];

			return $out;
		}

		/**
		 * Удаляет таблицу
		 * @param string $name - Наименование таблицы
		 * @return void
		 */
		public function deleteTableFromDB(string $name): void {
			$this->db->query("DROP TABLE `{$name}`");
		}

	}