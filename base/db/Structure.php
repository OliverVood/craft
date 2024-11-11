<?php

	namespace Base\DB;

	/**
	 * Для работы со структурой базы данных (базовый абстрактный класс)
	 */
	abstract class Structure {
		const ER_RELATIONSHIP_ONE				= 1;
		const ER_RELATIONSHIP_MANY				= 2;
		const ER_RELATIONSHIP_ONLY_ONE			= 3;
		const ER_RELATIONSHIP_ZERO_OR_ONE		= 4;
		const ER_RELATIONSHIP_ONE_OR_MANY		= 5;
		const ER_RELATIONSHIP_ZERO_OR_MANY		= 6;

		protected DB $db;
		protected string $name;
		protected array /** @var Table[] $tables */ $tables = [];

		public function __construct(DB $db, string $name) {
			$this->db = $db;
			$this->name = $name;
		}

		/**
		 * Возвращает структуру
		 * @return array
		 */
		public function get(): array {
			$structure = [
				'name' => $this->name,
				'tables' => [],
			];
			foreach ($this->tables as /** "@var Table $table */ $table) $structure['tables'][] = $table->structure();

			return $structure;
		}

		/**
		 * Создаёт таблицу и добавляет её в структуру
		 * @param string $name - Наименование таблицы
		 * @param string $description - Описание
		 * @return Table
		 */
		abstract public function table(string $name, string $description = ''): Table;

		/**
		 * Проверяет структуру базы данных
		 * @return array
		 */
		public function check(): array {
			$tablesApp = $this->getTablesApp();
			$tablesDB = $this->getTablesDB();
			$tables = array_unique(array_merge($tablesApp, $tablesDB));

			$out = [];

			foreach ($tables as $table) {

				if (!in_array($table, $tablesDB)) {
					$out[] = ['name' => $table, 'action' => Table::ACTION_CREATE, 'description' => __('Создать таблицу')];
					continue;
				}

				if (!in_array($table, $tablesApp)) {
					$out[] = ['name' => $table, 'action' => Table::ACTION_DELETE, 'description' => __('Удалить таблицу')];
					continue;
				}

				/** @var Table $tableInstance */ $tableInstance = $this->tables[$table];
				$checkTable = $tableInstance->check();
				if ($checkTable['action'] == Table::ACTION_UPDATE) {
					$out[] = ['name' => $table, 'action' => Table::ACTION_UPDATE, 'description' => __('Изменить таблицу'), 'fields' => $checkTable['fields']];
				}

			}

			return $out;
		}

		/**
		 * Исправляет структуру базы данных
		 * @param array $data - Данные
		 * @return bool
		 */
		public function make(array $data): bool {
			foreach ($data as $name => $table) {
				$action = (int)$table['action'];
				switch ($action) {
					case Table::ACTION_CREATE: /** @var Table $tableInstance */ $tableInstance = $this->tables[$name]; $tableInstance->create(); break;
					case Table::ACTION_UPDATE: /** @var Table $tableInstance */ $tableInstance = $this->tables[$name]; $tableInstance->update($table['fields']); break;
					case Table::ACTION_DELETE: $this->deleteTableFromDB($name); break;
				}
			}

			return true;
		}

		/**
		 * Возвращает имена таблиц в структуре приложения
		 * @return array
		 */
		protected function getTablesApp(): array {
			$out = []; foreach ($this->tables as /** @var Table $table */ $table) $out[] = $table->getName();

			return $out;
		}

		/**
		 * Возвращает имена таблиц в базе данных
		 * @return array
		 */
		abstract protected function getTablesDB(): array;

		/**
		 * Удаляет таблицу из базы данных
		 * @param string $name - Наименование таблицы
		 * @return void
		 */
		abstract public function deleteTableFromDB(string $name): void;

	}