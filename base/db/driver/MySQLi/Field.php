<?php

	namespace Base\DB\Driver\MySQLi;

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

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Line.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Fields/Timestamp.php';

	abstract class Field extends \Base\DB\Field {
		protected string $type;
		protected string $name;
		protected string $description;

		protected function __construct(string $type, string $name, string $description = '') {
			$this->type = $type;
			$this->name = $name;
			$this->description = $description;
		}

		public function structure() : array {
			return ['type' => $this->type, 'name' => $this->name, 'description' => $this->description];
		}

	}