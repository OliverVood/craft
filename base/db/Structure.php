<?php

	namespace Base\DB;

	class Structure {
		private string $name;
		protected array /** @var Table[] */ $tables;

		public function __construct(string $name) {
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
			foreach ($this->tables as $table) $structure['tables'][] = $table->structure();

			return $structure;
		}

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