<?php

	namespace Base\DB\Driver\MySQLi;

	use base\db\driver\MySQLi\keys\Primary;

	require DIR_BASE_DB . 'driver/MySQLi/Field.php';
	require DIR_BASE_DB . 'driver/MySQLi/Key.php';

	class Table extends \Base\DB\Table {
		private string $engine = 'InnoDB';
		private $encoding = 'utf8';
		private $collate = 'utf8mb4_general_ci';

		private ?Primary $primary = null;

		public function __construct(string $name, string $description = '') {
			parent::__construct($name, $description);
		}

		public function id(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt32($name, $description); $this->primary = new Primary($name, [$name]); return $this->fields[$name]; }
		public function bool(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Boolean($name, $description); return $this->fields[$name]; }
		public function int8(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int8($name, $description); return $this->fields[$name]; }
		public function int16(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int16($name, $description); return $this->fields[$name]; }
		public function int24(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int24($name, $description); return $this->fields[$name]; }
		public function int32(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int32($name, $description); return $this->fields[$name]; }
		public function int64(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int64($name, $description); return $this->fields[$name]; }
		public function uint8(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt8($name, $description); return $this->fields[$name]; }
		public function uint16(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt16($name, $description); return $this->fields[$name]; }
		public function uint24(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt24($name, $description); return $this->fields[$name]; }
		public function uint32(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt32($name, $description); return $this->fields[$name]; }
		public function uint64(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt64($name, $description); return $this->fields[$name]; }
		public function string(string $name, int $length, string $description = ''): Field { $this->fields[$name] = new Fields\Line($name, $description); return $this->fields[$name]; }
		public function timestamp(string $name, bool $update = false, string $description = ''): Field { $this->fields[$name] = new Fields\Timestamp($name, $description); return $this->fields[$name]; }

		public function addPrimary(string $name, array $fields): void { $this->primary = new Primary($name, $fields); }

		/**
		 * Возвращает структуру таблицы
		 * @return array
		 */
		public function structure(): array {
			$structure = [
				'name' => $this->name,
				'description' => $this->description,
				'params' => [
					'engine' => $this->engine,
					'encoding' => $this->encoding,
					'collate' => $this->collate
				],
				'fields' => [],
				'keys' => [
					'primaries' => [],
					'foreigners' => []
				]
			];
			foreach ($this->fields as $field) $structure['fields'][] = $field->structure();
			if ($this->primary) $structure['keys']['primaries'][] = $this->primary->structure();
//			foreach ($this->foreigners as $foreigner) $table['keys']['foreigners'][] = $foreigner->Structure();//TODO Структура

			return $structure;
		}

	}