<?php

	namespace Base\DB\Driver\MySQLi;

	class Structure extends \Base\DB\Structure {

		/**
		 * Создаёт таблицу и добавляет её в структуру
		 * @param string $name - Наименование таблицы
		 * @param string $description - Описание
		 * @return Table
		 */
		public function table(string $name, string $description = ''): Table {
			$this->tables[$name] = new Table($name, $description);

			return $this->tables[$name];
		}

	}