<?php

	namespace Base\Editor;

	/**
	 * Тексты редактора
	 */
	trait Texts {

		protected string $titleSelect = 'UNDEFINED TEXT';
		protected string $titleBrowse = 'UNDEFINED TEXT';
		protected string $titleCreate = 'UNDEFINED TEXT';
		protected string $titleUpdate = 'UNDEFINED TEXT';

		protected string $textDoBrowse = 'UNDEFINED TEXT';
		protected string $textDoUpdate = 'UNDEFINED TEXT';
		protected string $textDoDelete = 'UNDEFINED TEXT';
		protected string $textSetState = 'UNDEFINED TEXT';

		protected string $textDeleteConfirm = 'UNDEFINED TEXT';
		protected string $textSetStateConfirm = 'UNDEFINED TEXT';

		protected string $textResponseOkCreate = 'UNDEFINED TEXT';
		protected string $textResponseOkUpdate = 'UNDEFINED TEXT';
		protected string $textResponseOkDelete = 'UNDEFINED TEXT';
		protected string $textResponseOkSetState = 'UNDEFINED TEXT';

		public string $textBtnCreate = 'UNDEFINED TEXT';
		public string $textBtnUpdate = 'UNDEFINED TEXT';

		protected string $textResponseErrorAccess = 'UNDEFINED TEXT';
		protected string $textResponseErrorNotFound = 'UNDEFINED TEXT';
		protected string $textResponseErrorCreate = 'UNDEFINED TEXT';
		protected string $textResponseErrorUpdate = 'UNDEFINED TEXT';
		protected string $textResponseErrorDelete = 'UNDEFINED TEXT';
		protected string $textResponseErrorState = 'UNDEFINED TEXT';
		protected string $textResponseErrorValidate = 'UNDEFINED TEXT';

		/**
		 * Устанавливает текста для редактора
		 * @return void
		 */
			protected function regTexts(): void {
			$this->titleSelect = __('Выборка');
			$this->titleBrowse = __('Просмотр');
			$this->titleCreate = __('Создание');
			$this->titleUpdate = __('Редактирование');

			$this->textDoBrowse = __('Просмотреть');
			$this->textDoUpdate = __('Изменить');
			$this->textDoDelete = __('Удалить');
			$this->textSetState = __('Изменить состояние');

			$this->textDeleteConfirm = __('Удалить?');
			$this->textSetStateConfirm = __('Изменить состояние?');

			$this->textResponseOkCreate = __('Создано');
			$this->textResponseOkUpdate = __('Изменено');
			$this->textResponseOkDelete = __('Удалено');
			$this->textResponseOkSetState = __('Изменено состояние');

			$this->textBtnCreate = __('Создать');
			$this->textBtnUpdate = __('Изменить');

			$this->textResponseErrorAccess = __('Ошибка доступа. Недостаточно прав.');
			$this->textResponseErrorNotFound = __('Элемент не найден');
			$this->textResponseErrorCreate = __('Ошибка сохранения');
			$this->textResponseErrorUpdate = __('Ошибка обновления');
			$this->textResponseErrorDelete = __('Ошибка удаления');
			$this->textResponseErrorState = __('Ошибка установки состояния');
			$this->textResponseErrorValidate = __('Ошибка валидации данных');
		}

	}