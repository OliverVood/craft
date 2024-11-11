<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Timestamp для базы данных mysqli
	 */
	class Timestamp extends Field {
		private bool $update;

		public function __construct(DB $db, string $name, bool $update, string $description = '') {
			parent::__construct($db, 'timestamp', $name, $description);

			$this->update = $update;

			$this->_type = ['timestamp'];
			$this->_null = 'NO';
			$this->_key = '';
			$this->_default = 'CURRENT_TIMESTAMP';
			$this->_extra = $this->update ? ['DEFAULT_GENERATED on update CURRENT_TIMESTAMP', 'on update CURRENT_TIMESTAMP'] : ['DEFAULT_GENERATED', ''];
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
		private function getFormat(): string { return "`{$this->name}` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP" . ($this->update ? ' ON UPDATE CURRENT_TIMESTAMP' : ''); }

	}