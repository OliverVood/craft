<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Enum для базы данных mysqli
	 */
	class Enum extends Field {
		private array $enum;

		public function __construct(DB $db, string $name, array $enum, string $description = '') {
			parent::__construct($db, 'enum', $name, $description);

			$this->enum = $enum;

			$this->_type = ["enum('" . implode("','", $this->enum) . "')"];
			$this->_null = 'NO';
			$this->_key = '';
			$this->_default = null;
			$this->_extra = [''];
		}

		/**
		 * Возвращает формат создания поля
		 * @return string
		 */
		public function creationFormat(): string { return $this->GetFormat(); }

		/**
		 * Возвращает формат изменения поля
		 * @return string
		 */
		public function updatingFormat(): string { return $this->getFormat(); }

		/**
		 * Возвращает формат поля
		 * @return string
		 */
		private function getFormat(): string { return "`{$this->name}` enum('" . implode("','", $this->enum) . "') NOT NULL"; }

	}