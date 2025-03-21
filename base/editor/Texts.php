<?php

	namespace Base\Editor;

	/**
	 * Тексты редактора
	 */
	trait Texts {

		protected string $titleSelect = 'Выборка';
		protected string $titleBrowse = 'Просмотр';
		protected string $titleCreate = 'Создание';
		protected string $titleUpdate = 'Редактирование';

		protected string $textDoBrowse = 'UNDEFINED TEXT';
		protected string $textDoUpdate = 'Изменить';
		protected string $textDoDelete = 'Удалить';
		protected string $textSetState = 'UNDEFINED TEXT';

		protected string $textDeleteConfirm = 'Удалить?';
		protected string $textSetStateConfirm = 'UNDEFINED TEXT';

		protected string $textResponseOkCreate = 'Создано';
		protected string $textResponseOkUpdate = 'Изменено';
		protected string $textResponseOkDelete = 'Удалено';
		protected string $textResponseOkSetState = 'UNDEFINED TEXT';

		public string $textBtnCreate = 'UNDEFINED TEXT';
		public string $textBtnUpdate = 'UNDEFINED TEXT';

		protected string $textResponseErrorAccess = 'Не достаточно прав';
		protected string $textResponseErrorNotFound = 'UNDEFINED TEXT';
		protected string $textResponseErrorCreate = 'UNDEFINED TEXT';
		protected string $textResponseErrorUpdate = 'UNDEFINED TEXT';
		protected string $textResponseErrorDelete = 'UNDEFINED TEXT';
		protected string $textResponseErrorState = 'UNDEFINED TEXT';
		protected string $textResponseErrorValidate = 'Ошибка валидации данных';

		/**
		 * Устанавливает текста для редактора
		 * @return void
		 */
			protected function regTexts(): void {
			$this->textDoBrowse = __('Просмотреть');
			$this->textSetState = __('Изменить состояние');

			$this->textSetStateConfirm = __('Изменить состояние?');

			$this->textResponseOkSetState = __('Изменено состояние');

			$this->textBtnCreate = __('Создать');
			$this->textBtnUpdate = __('Изменить');

			$this->textResponseErrorNotFound = __('Элемент не найден');
			$this->textResponseErrorCreate = __('Ошибка сохранения');
			$this->textResponseErrorUpdate = __('Ошибка обновления');
			$this->textResponseErrorDelete = __('Ошибка удаления');
			$this->textResponseErrorState = __('Ошибка установки состояния');
		}

	}