<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Int16 для базы данных mysqli
	 */
	class Int16 extends Field {
		protected int $size = 6;

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'int16', $name, $description);

			$this->_type = ['smallint', "smallint({$this->size})"];
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
		private function getFormat(): string { return "`{$this->name}` smallint NOT NULL DEFAULT '0'"; }

	}