<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле StringText для базы данных mysqli
	 */
	class StringText extends Field {
		private int $length;

		public function __construct(DB $db, string $name, int $length, string $description = '') {
			parent::__construct($db, 'string', $name, $description);

			$this->length = $length;

			$this->_type = ["varchar({$this->length})"];
			$this->_null = 'NO';
			$this->_key = '';
			$this->_default = '';
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
		private function getFormat(): string { return "`{$this->name}` varchar({$this->length}) NOT NULL DEFAULT ''"; }

	}