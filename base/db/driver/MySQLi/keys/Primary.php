<?php

	namespace base\db\driver\MySQLi\keys;

	use Base\DB\Driver\MySQLi\Key;

	/**
	 * Для работы с первичным ключом таблицы базы данных mysqli
	 */
	class Primary extends Key {

		public function __construct(string $name, array $fields) {
			parent::__construct('primary', $name, $fields);
		}

		/**
		 * Возвращает структуру ключа
		 * @return array
		 */
		public function structure(): array {
			return [
				'type' => $this->type,
				'name' => $this->name,
				'fields' => $this->fields
			];
		}

	}