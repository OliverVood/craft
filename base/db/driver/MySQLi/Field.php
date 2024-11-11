<?php

	namespace Base\DB\Driver\MySQLi;
	use Base\DB\DB;

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Boolean.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Int8.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Int16.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Int24.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Int32.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Int64.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/UInt8.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/UInt16.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/UInt24.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/UInt32.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/UInt64.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/RealFloat.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/RealDouble.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/StringText.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Text.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Timestamp.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Enum.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Set.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/ID.php';

	/**
	 * Для работы с полями таблицы базы данных mysqli
	 */
	abstract class Field extends \Base\DB\Field {
		protected array $_type;
		protected string $_null;
		protected string $_key;
		protected ?string $_default;
		protected array $_extra;

		protected function __construct(DB $db, string $type, string $name, string $description = '') {
			parent::__construct($db, $type, $name, $description);
		}

		/**
		 * Возвращает структуру поля
		 * @return array
		 */
		public function structure() : array {
			return ['type' => $this->type, 'name' => $this->name, 'description' => $this->description];
		}

		/**
		 * Проверка поля
		 * @param array $data - Данные
		 * @return bool
		 */
		public function check(array $data): bool {
			if (
				!in_array($data['Type'], $this->_type) ||
				$data['Null'] !== $this->_null ||
				$data['Key'] !== $this->_key ||
				$data['Default'] !== $this->_default ||
				!in_array($data['Extra'], $this->_extra)
			) return false;

			return true;
		}

		/**
		 * Создаёт поле
		 * @param string $tableName - Наименование таблицы
		 * @return bool
		 */
		public function create(string $tableName): bool {
			$this->db->query("ALTER TABLE `{$tableName}` ADD {$this->creationFormat()}");

			return true;
		}

		/**
		 * Обновляет поле
		 * @param string $tableName - Наименование таблицы
		 * @return bool
		 */
		public function update(string $tableName): bool {
			$this->db->Query("ALTER TABLE `{$tableName}` CHANGE `{$this->name}` {$this->updatingFormat()}");

			return true;
		}

		/**
		 * Возвращает формат создания поля
		 * @return string
		 */
		abstract public function creationFormat(): string;

		/**
		 * Возвращает формат изменения поля
		 * @return string
		 */
		abstract public function updatingFormat(): string;

	}