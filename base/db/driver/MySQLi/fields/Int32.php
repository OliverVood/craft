<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Int32 для базы данных mysqli
	 */
	class Int32 extends Field {
		protected int $size = 10;

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'int32', $name, $description);

			$this->_type = ['int', "int({$this->size})"];
			$this->_null = 'NO';
			$this->_key = '';
			$this->_default = '0';
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
		private function getFormat(): string { return "`{$this->name}` int NOT NULL DEFAULT '0'"; }

	}