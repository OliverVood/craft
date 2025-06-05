<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Структура пользовательских таблиц
	 */
	class NewStructure {
		private Table $table_MyTable;
		private Table $table_MyTable2;

		public function __construct() {
			$structure = app()->db('craft')->structure();

			$this->table_MyTable = $structure->table('my_table', __('Пользовательская таблица my_table'));
			$this->table_MyTable->id('id', __('Идентификатор'));
			$this->table_MyTable->uint8('state', __('Состояние'));
			$this->table_MyTable->timestamp('datecr', false, __('Дата создания'));
			$this->table_MyTable->timestamp('datemd', true, __('Дата изменения'));

			$this->table_MyTable2 = $structure->table('my_table_2', __('Пользовательская таблица my_table_2'));
			$this->table_MyTable2->id('id', __('Идентификатор'));
			$this->table_MyTable2->uint8('state', __('Состояние'));
			$this->table_MyTable2->timestamp('datecr', false, __('Дата создания'));
			$this->table_MyTable2->timestamp('datemd', true, __('Дата изменения'));
		}

	}

	new NewStructure();