<?php

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Структура таблиц сущности Статистика
	 */
	class Statistics {
		private Table $table_ip;
		private Table $table_act;
		private Table $test_table;

		public function __construct() {
			$structure = db('craft')->structure();

			$this->table_ip = $structure->table('statistics_ip', 'Статистика посещений');
			$this->table_ip->id('id', 'Идентификатор');
			$this->table_ip->timestamp('datecr', false, 'Дата создания');
			$this->table_ip->uint32('ip', 'IP адрес');
			$this->table_ip->uint32('cid', 'ID клиента');
			$this->table_ip->string('path', 255, 'Путь');
			$this->table_ip->string('params', 255, 'Параметры');
			$this->table_ip->AddForeign('foreign', ['cid'], 'clients', ['id']);

			$this->table_act = $structure->table('statistics_act', 'Статистика действий');
			$this->table_act->id('id', 'Идентификатор');
			$this->table_act->timestamp('datecr', false, 'Дата создания');
			$this->table_act->uint32('cid', 'ID клиента');
			$this->table_act->string('object', 30, 'Объект');
			$this->table_act->string('action', 30, 'Действие');
			$this->table_act->string('params', 500, 'Параметры');
			$this->table_act->AddForeign('foreign', ['cid'], 'clients', ['id']);

			$this->test_table = $structure->table('test_table', 'Статистика действий');
			$this->test_table->id('id', 'Идентификатор');
			$this->test_table->timestamp('datecr', false, 'Дата создания');
			$this->test_table->uint32('cid', 'ID клиента');
			$this->test_table->string('object', 30, 'Объект');
//			$this->test_table->string('action', 30, 'Действие');
//			$this->test_table->string('params', 500, 'Параметры');
			$this->test_table->string('action', 40, 'Действие');
//			$this->test_table->string('params', 100, 'Параметры');
			$this->test_table->string('params2', 100, 'Параметры');
		}

	}

	new Statistics();