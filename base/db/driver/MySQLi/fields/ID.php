<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле ID для базы данных mysqli
	 */
	class ID extends Field {
		protected int $size = 10;

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'id', $name, $description);

			$this->_type = ['int unsigned', "int({$this->size}) unsigned"];
			$this->_null = 'NO';
			$this->_key = 'PRI';
			$this->_default = null;
			$this->_extra = ['auto_increment'];
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
		private function getFormat(): string { return "`{$this->name}` int unsigned NOT NULL AUTO_INCREMENT"; }

	}