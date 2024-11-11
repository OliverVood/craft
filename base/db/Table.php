<?php

	namespace Base\DB;

	require DIR_BASE_DB . 'Field.php';

	/**
	 * Для работы с таблицами базы данных (базовый абстрактный класс)
	 */
	abstract class Table {
		const ACTION_OK						=  1;
		const ACTION_CREATE					= -1;
		const ACTION_UPDATE					= -2;
		const ACTION_DELETE 				= -3;

		protected DB $db;
		protected string $name;
		protected string $description;
		protected array /** @var Field[] $fields */ $fields;

		public function __construct(DB $db, string $name, string $description = '') {
			$this->db = $db;
			$this->name = $name;
			$this->description = $description;

			$this->fields = [];
		}

		/**
		 * Возвращает структуру таблицы
		 * @return array
		 */
		abstract protected function structure(): array;

		/**
		 * Проверяет структуру таблицы
		 * @return array
		 */
		abstract protected function check(): array;

		/**
		 * Создаёт таблицу
		 * @return void
		 */
		abstract public function create(): void;

		/**
		 * Обновляет таблицу
		 * @param array $fields - Перечень полей для изменения
		 * @return bool
		 */
		abstract protected function update(array $fields): bool;

		/**
		 * Возвращает имя таблицы
		 * @return string
		 */
		public function getName(): string {
			return $this->name;
		}

		abstract public function id(string $name, string $description = ''): Field;
		abstract public function bool(string $name, string $description = ''): Field;
		abstract function int8(string $name, string $description = ''): Field;
		abstract public function int16(string $name, string $description = ''): Field;
		abstract public function int24(string $name, string $description = ''): Field;
		abstract public function int32(string $name, string $description = ''): Field;
		abstract public function int64(string $name, string $description = ''): Field;
		abstract public function uint8(string $name, string $description = ''): Field;
		abstract public function uint16(string $name, string $description = ''): Field;
		abstract public function uint24(string $name, string $description = ''): Field;
		abstract public function uint32(string $name, string $description = ''): Field;
		abstract public function uint64(string $name, string $description = ''): Field;
		abstract public function float(string $name, string $description = ''): Field;
		abstract public function double(string $name, string $description = ''): Field;
		abstract public function string(string $name, int $length, string $description = ''): Field;
		abstract public function text(string $name, string $description = ''): Field;
		abstract public function timestamp(string $name, bool $update = false, string $description = ''): Field;
		abstract public function enum(string $name, array $enum, string $description = ''): Field;
		abstract public function set(string $name, array $set, string $description = ''): Field;

		abstract public function addForeign(string $name, array $fields, string $references_table, array $references_fields, int $relationship_from = Structure::ER_RELATIONSHIP_MANY, int $relationship_to = Structure::ER_RELATIONSHIP_ONE): void;

		/**
		 * Возвращает имена полей таблицы в структуре приложения
		 * @return array
		 */
		protected function getFieldsApp(): array {
			$out = [];
			foreach ($this->fields as $name => $field) $out[] = $name;

			return $out;
		}

		/**
		 * Возвращает имена полей таблицы и их данные из базы данных
		 * @return array
		 */
		abstract protected function getFieldsAndDataDB(): array;

		/**
		 * Удаляет поле из таблицы
		 * @param string $name - Наименование поля
		 * @return void
		 */
		abstract protected function deleteFieldFromTable(string $name): void;

	}