<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Структура таблиц статистики
	 */
	class Statistics {
		private Table $table_ip;
		private Table $table_act;

		public function __construct() {
			$structure = db('craft')->structure();

			$this->table_ip = $structure->table('statistics_ip', __('Статистика посещений'));
			$this->table_ip->id('id', __('Идентификатор'));
			$this->table_ip->timestamp('datecr', false, __('Дата создания'));
			$this->table_ip->uint32('ip', __('IP адрес'));
			$this->table_ip->uint32('cid', __('ID клиента'));
			$this->table_ip->string('path', 255, __('Путь'));
			$this->table_ip->string('params', 255, __('Параметры'));
			$this->table_ip->AddForeign('foreign', ['cid'], 'clients', ['id']);

			$this->table_act = $structure->table('statistics_act', __('Статистика действий'));
			$this->table_act->id('id', __('Идентификатор'));
			$this->table_act->timestamp('datecr', false, __('Дата создания'));
			$this->table_act->uint32('cid', __('ID клиента'));
			$this->table_act->string('object', 30, __('Объект'));
			$this->table_act->string('action', 30, __('Действие'));
			$this->table_act->string('params', 500, __('Параметры'));
			$this->table_act->AddForeign('foreign', ['cid'], 'clients', ['id']);
		}

	}

	new Statistics();