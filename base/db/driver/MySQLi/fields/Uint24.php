<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Uint24 для базы данных mysqli
	 */
	class Uint24 extends Field {
		protected int $size = 8;

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'uint24', $name, $description);

			$this->_type = ['mediumint unsigned', "mediumint({$this->size}) unsigned"];
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
		private function getFormat(): string { return "`{$this->name}` mediumint unsigned NOT NULL DEFAULT '0'"; }

	}