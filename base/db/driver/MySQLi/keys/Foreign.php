<?php

	namespace Base\DB\Driver\MySQLi\keys;

	use Base\DB\Driver\MySQLi\Key;
	use Base\DB\Structure;

	/**
	 * Для работы с внешним ключом таблицы базы данных mysqli
	 */
	class Foreign extends Key {
		private string $references_table;
		private array $references_fields;
		private int $relationship_from;
		private int $relationship_to;

		public function __construct(string $name, array $fields, string $references_table, array $references_fields, int $relationship_from = Structure::ER_RELATIONSHIP_MANY, int $relationship_to = Structure::ER_RELATIONSHIP_ONE) {
			parent::__construct('foreign', $name, $fields);

			$this->references_table = $references_table;
			$this->references_fields = $references_fields;
			$this->relationship_from = $relationship_from;
			$this->relationship_to = $relationship_to;
		}

		/**
		 * Возвращает структуру ключа
		 * @return array
		 */
		public function structure(): array {
			return [
				'type' => $this->type,
				'name' => $this->name,
				'fields' => $this->fields,
				'references_table' => $this->references_table,
				'references_fields' => $this->references_fields,
				'relationship_from' => $this->relationship_from,
				'relationship_to' => $this->relationship_to,
			];
		}

	}