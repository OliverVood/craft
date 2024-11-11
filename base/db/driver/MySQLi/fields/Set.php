<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\DB;
	use Base\DB\Driver\MySQLi\Field;

	/**
	 * Поле Set для базы данных mysqli
	 */
	class Set extends Field {
		private array $set;

		public function __construct(DB $db, string $name, array $set, string $description = '') {
			parent::__construct($db, 'set', $name, $description);

			$this->set = $set;

			$this->_type = ["set('" . implode("','", $this->set) . "')"];
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
		private function getFormat(): string { return "`{$this->name}` set('" . implode("','", $this->set) . "') NOT NULL"; }

	}