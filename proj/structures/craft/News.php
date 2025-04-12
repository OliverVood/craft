<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Структура таблиц новостей
	 */
	class News {
		private Table $table_news;

		public function __construct() {
			$structure = db('craft')->structure();

			$this->table_news = $structure->table('news', __('Новости'));
			$this->table_news->id('id', __('Идентификатор'));
			$this->table_news->uint8('state', __('Состояние'));
			$this->table_news->timestamp('datecr', false, __('Дата создания'));
			$this->table_news->timestamp('datemd', true, __('Дата изменения'));
			$this->table_news->timestamp('datepb', false, __('Дата публикации'));
			$this->table_news->string('header', 255, __('Заголовок'));
			$this->table_news->text('content', __('Содержимое'));
			$this->table_news->string('hash', 32, __('Хэш файла'));
			$this->table_news->string('ext', 6, __('Расширение файла'));
		}

	}

	new News();