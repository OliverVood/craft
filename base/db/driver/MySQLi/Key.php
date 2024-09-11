<?php

	namespace Base\DB\Driver\MySQLi;

	require DIR_BASE_DB . 'driver/MySQLi/keys/Primary.php';

	abstract class Key {
		protected string $type;
		protected string $name;
		protected array $fields = [];

		protected function __construct(string $type, string $name, array $fields) {
			$this->type = $type;
			$this->name = $name;
			$this->fields = $fields;
		}

		abstract public function structure(): array;

	}