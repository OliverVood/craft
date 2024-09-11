<?php

	namespace base\db\driver\MySQLi\keys;

	use Base\DB\Driver\MySQLi\Key;

	class Primary extends Key {

		public function __construct(string $name, array $fields) {
			parent::__construct('primary', $name, $fields);
		}

		public function structure(): array {
			return [
				'type' => $this->type,
				'name' => $this->name,
				'fields' => $this->fields
			];
		}

	}