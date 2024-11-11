<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Text для базы данных mysqli
	 */
	class Text extends Field {

		public function __construct(DB $db, string $name, string $description = '') {
			parent::__construct($db, 'text', $name, $description);

			$this->_type = ['text'];
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
		private function getFormat(): string { return "`{$this->name}` text NOT NULL"; }

	}