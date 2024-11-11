<?php

	namespace Base\DB\Driver\MySQLi;

	use Base\DB\Driver\MySQLi\keys\Foreign;
	use base\db\driver\MySQLi\keys\Primary;

	require DIR_BASE_DB . 'driver/MySQLi/Field.php';
	require DIR_BASE_DB . 'driver/MySQLi/Key.php';

	/**
	 * Для работы с таблицами базы данных mysqli
	 */
	class Table extends \Base\DB\Table {
		private string $engine = 'InnoDB';
		private $encoding = 'utf8';
		private $collate = 'utf8mb4_general_ci';

		private ?Primary $primary = null;
		private array /** Foreign[] $foreign */ $foreign = [];

		public function __construct(\Base\DB\DB $db, string $name, string $description = '') {
			parent::__construct($db, $name, $description);
		}

		public function id(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\ID($this->db, $name, $description); $this->addPrimary($name, [$name]); return $this->fields[$name]; }
		public function bool(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Boolean($this->db, $name, $description); return $this->fields[$name]; }
		public function int8(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int8($this->db, $name, $description); return $this->fields[$name]; }
		public function int16(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int16($this->db, $name, $description); return $this->fields[$name]; }
		public function int24(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int24($this->db, $name, $description); return $this->fields[$name]; }
		public function int32(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int32($this->db, $name, $description); return $this->fields[$name]; }
		public function int64(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int64($this->db, $name, $description); return $this->fields[$name]; }
		public function uint8(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt8($this->db, $name, $description); return $this->fields[$name]; }
		public function uint16(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt16($this->db, $name, $description); return $this->fields[$name]; }
		public function uint24(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt24($this->db, $name, $description); return $this->fields[$name]; }
		public function uint32(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt32($this->db, $name, $description); return $this->fields[$name]; }
		public function uint64(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt64($this->db, $name, $description); return $this->fields[$name]; }
		public function float(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\RealFloat($this->db, $name, $description); return $this->fields[$name]; }
		public function double(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\RealDouble($this->db, $name, $description); return $this->fields[$name]; }
		public function string(string $name, int $length, string $description = ''): Field { $this->fields[$name] = new Fields\StringText($this->db, $name, $length, $description); return $this->fields[$name]; }
		public function text(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Text($this->db, $name, $description); return $this->fields[$name]; }
		public function timestamp(string $name, bool $update = false, string $description = ''): Field { $this->fields[$name] = new Fields\Timestamp($this->db, $name, $update, $description); return $this->fields[$name]; }
		public function enum(string $name, array $enum, string $description = ''): Field { $this->fields[$name] = new Fields\Enum($this->db, $name, $enum, $description); return $this->fields[$name]; }
		public function set(string $name, array $set, string $description = ''): Field { $this->fields[$name] = new Fields\Set($this->db, $name, $set, $description); return $this->fields[$name]; }

		public function addPrimary(string $name, array $fields): void { $this->primary = new Primary($name, $fields); }
		public function addForeign(string $name, array $fields, string $references_table, array $references_fields, int $relationship_from =  \Base\DB\Structure::ER_RELATIONSHIP_MANY, int $relationship_to = \Base\DB\Structure::ER_RELATIONSHIP_ONE): void { $this->foreign[] = new Foreign($name, $fields, $references_table, $references_fields, $relationship_from, $relationship_to); }

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
			foreach ($this->foreign as $foreign) $structure['keys']['foreigners'][] = $foreign->structure();

			return $structure;
		}

		/**
		 * Проверяет структуру таблицы
		 * @return array
		 */
		public function check(): array {
			$out = ['action' => self::ACTION_OK, 'fields' => []];

			$fieldsApp = $this->getFieldsApp();
			[$fieldsDB, $fieldsDBData] = $this->getFieldsAndDataDB();
			$fields = array_unique(array_merge($fieldsApp, $fieldsDB));

			foreach ($fields as $field) {
				if (!in_array($field, $fieldsDB)) {
					/** @var \Base\DB\Field $fieldInstance */ $fieldInstance = $this->fields[$field];
					$out['fields'][] = ['name' => $field, 'action' => \Base\DB\Field::ACTION_CREATE, 'description' => __('Добавить поле'), 'details' => $fieldInstance->creationFormat()];
					$out['action'] = self::ACTION_UPDATE;
					continue;
				}

				if (!in_array($field, $fieldsApp)) {
					$out['fields'][] = ['name' => $field, 'action' => \Base\DB\Field::ACTION_DELETE, 'description' => __('Удалить поле')];
					$out['action'] = self::ACTION_UPDATE;
					continue;
				}

				/** @var \Base\DB\Field $fieldInstance */ $fieldInstance = $this->fields[$field];
				if (!$fieldInstance->check($fieldsDBData[$field])) {
					$out['fields'][] = ['name' => $field, 'action' => \Base\DB\Field::ACTION_UPDATE, 'description' => __('Изменить поле'), 'details' => $fieldInstance->updatingFormat()];
					$out['action'] = self::ACTION_UPDATE;
				}

			}

			return $out;
		}

		/**
		 * Создаёт таблицу
		 * @return void
		 */
		public function create(): void {
			$fieldsList = [];
			foreach ($this->fields as /** @var Field $field */ $field) $fieldsList[] = $field->creationFormat();
			$fields = implode(', ', $fieldsList);

			$after = $this->primary ? ", PRIMARY KEY (`{$this->primary->getFields()[0]}`)" : '';
			$this->db->query("CREATE TABLE `{$this->name}` ({$fields}{$after}) ENGINE = {$this->engine} DEFAULT CHARSET = {$this->encoding}");
		}

		/**
		 * Обновляет таблицу
		 * @param array $fields - Перечень полей для изменения
		 * @return bool
		 */
		public function update(array $fields): bool {
			foreach ($fields as $name => ['action' => $action]) {
				switch ($action) {
					case \Base\DB\Field::ACTION_CREATE: /** @var Field $fieldInstance */ $fieldInstance = $this->fields[$name]; $fieldInstance->create($this->name); break;
					case \Base\DB\Field::ACTION_UPDATE: /** @var Field $fieldInstance */ $fieldInstance = $this->fields[$name]; $fieldInstance->update($this->name); break;
					case \Base\DB\Field::ACTION_DELETE: $this->deleteFieldFromTable($name); break;
				}
			}

			return true;
		}

		/**
		 * Возвращает имена полей таблицы и их данные из базы данных
		 * @return array
		 */
		protected function getFieldsAndDataDB(): array {
			$response = $this->db->query("SHOW FIELDS FROM `{$this->name}`");
			$fieldsList = [];
			$fieldsData = [];
			foreach ($response->each() as $row) {
				$fieldsList[] = $row['Field'];
				$fieldsData[$row['Field']] = $row;
			}

			return [$fieldsList, $fieldsData];
		}

		/**
		 * Удаляет поле из таблицы
		 * @param string $name - Наименование поля
		 * @return void
		 */
		protected function deleteFieldFromTable(string $name): void {
			$this->db->query("ALTER TABLE `{$this->name}` DROP COLUMN `{$name}`");
		}

	}