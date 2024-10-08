<?php

	namespace Proj\Structures;

	use Base\DB\Structure;
	use Base\DB\Table;
	use Proj\DB;

	class Statistic {
		private Structure $structure;

		private Table $table_ip;
		private Table $table_act;

		public function __construct() {
			$this->structure = DB\Craft::instance()->structure;

			$this->table_ip = $this->structure->table('statistics_ip', 'Статистика посещений');
			$this->table_ip->id('id', 'Идентификатор');
			$this->table_ip->timestamp('datecr', false, 'Дата создания');
			$this->table_ip->uint32('ip', 'IP адрес');
			$this->table_ip->uint32('cid', 'ID клиента');
			$this->table_ip->string('path', 255, 'Путь');
			$this->table_ip->string('params', 255, 'Параметры');
//			$this->table_ip->AddForeign('foreign', ['cid'], Consts\Users::TABLES['clients'], ['id']);

			$this->table_act = $this->structure->table('statistics_act', 'Статистика действий');
			$this->table_act->id('id', 'Идентификатор');
			$this->table_act->timestamp('datecr', false, 'Дата создания');
			$this->table_act->uint32('cid', 'ID клиента');
			$this->table_act->string('object', 30, 'Объект');
			$this->table_act->string('action', 30, 'Действие');
			$this->table_act->string('params', 500, 'Параметры');
//			$this->table_act->AddForeign('foreign', ['cid'], Consts\Users::TABLES['clients'], ['id']);
		}

	}

	new Statistic();