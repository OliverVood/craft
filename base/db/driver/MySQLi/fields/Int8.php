<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Int8 для базы данных mysqli
	 */
	class Int8 extends Field {
		protected int $size = 3;

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'int8', $name, $description);

			$this->_type = ['tinyint', "tinyint({$this->size})"];
			$this->_null = 'NO';
			$this->_key = '';
			$this->_default = '0';
			$this->_extra = [''];
		}

		/**
		 * Возвращает формат создания поля
		 * @return string
		 */
		public function creationFormat(): string { return $this->getFormat(); }

		/**
		 * Возвращает формат изменения поля
		 * @return string
		 */
		public function updatingFormat(): string { return $this->getFormat(); }

		/**
		 * Возвращает формат поля
		 * @return string
		 */
		private function getFormat(): string { return "`{$this->name}` tinyint(3) NOT NULL DEFAULT '0'"; }

	}