<?php

	namespace Base\DB\Driver\MySQLi;

	require DIR_BASE_DB . 'driver/MySQLi/keys/Primary.php';
	require DIR_BASE_DB . 'driver/MySQLi/keys/Foreign.php';

	/**
	 * Для работы с ключами таблицы базы данных mysqli (абстрактный класс ключей)
	 */
	abstract class Key {
		protected string $type;
		protected string $name;
		protected array $fields = [];

		protected function __construct(string $type, string $name, array $fields) {
			$this->type = $type;
			$this->name = $name;
			$this->fields = $fields;
		}

		/**
		 * Возвращает структуру ключа
		 * @return array
		 */
		abstract public function structure(): array;

		/**
		 * Возвращает поля ключа
		 * @return array
		 */
		public function getFields(): array {
			return $this->fields;
		}

	}