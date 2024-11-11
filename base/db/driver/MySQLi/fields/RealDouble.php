<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле RealDouble для базы данных mysqli
	 */
	class RealDouble extends Field {

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'double', $name, $description);

			$this->_type = ['double'];
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
		private function getFormat(): string { return "`{$this->name}` double NOT NULL DEFAULT '0'"; }

	}