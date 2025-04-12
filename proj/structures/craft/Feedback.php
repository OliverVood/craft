<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Структура таблиц обратной связи
	 */
	class Feedback {
		private Table $table_feedback;

		public function __construct() {
			$structure = app()->db('craft')->structure();

			$this->table_feedback = $structure->table('feedback', __('Обратная связь'));
			$this->table_feedback->id('id', __('Идентификатор'));
			$this->table_feedback->uint8('state', __('Состояние'));
			$this->table_feedback->timestamp('datecr', false, __('Дата создания'));
			$this->table_feedback->timestamp('datemd', true, __('Дата изменения'));
			$this->table_feedback->string('name', 255, __('Имя'));
			$this->table_feedback->string('contacts', 255, __('Контакты'));
			$this->table_feedback->string('letter', 255, __('Тема'));
			$this->table_feedback->text('content', __('Содержимое'));
		}

	}

	new Feedback();