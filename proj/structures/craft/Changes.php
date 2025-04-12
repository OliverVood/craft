<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Структура таблиц изменений
	 */
	class Changes {
		private Table $table_changes;
		private Table $table_change;

		public function __construct() {
			$structure = app()->db('craft')->structure();

			$this->table_changes = $structure->table('changes', __('Список актуального'));
			$this->table_changes->id('id', __('Идентификатор'));
			$this->table_changes->uint8('state', __('Состояние'));
			$this->table_changes->timestamp('datecr', false, __('Дата создания'));
			$this->table_changes->timestamp('datemd', true, __('Дата изменения'));
			$this->table_changes->timestamp('datepb', false, __('Дата публикации'));
			$this->table_changes->string('work_header', 255, __('Рабочий заголовок'));
			$this->table_changes->string('header', 255, __('Заголовок'));

			$this->table_change = $structure->table('change', __('Актуальное'));
			$this->table_change->id('id', __('Идентификатор'));
			$this->table_change->uint32('cid', __('ID списка актуального'));
			$this->table_change->uint8('state', __('Состояние'));
			$this->table_change->timestamp('datecr', false, __('Дата создания'));
			$this->table_change->timestamp('datemd', true, __('Дата изменения'));
			$this->table_change->string('header', 255, __('Заголовок'));
			$this->table_change->text('content', __('Содержимое'));
			$this->table_change->string('hash', 32, __('Хэш файла'));
			$this->table_change->string('ext', 6, __('Расширение файла'));
			$this->table_change->addForeign('foreign', ['cid'], 'changes', ['id']);
		}

	}

	new Changes();