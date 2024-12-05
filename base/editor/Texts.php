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

		protected string $textDoBrowse = 'Просмотреть';
		protected string $textDoUpdate = 'Изменить';
		protected string $textDoDelete = 'Удалить';
		protected string $textSetState = 'Изменить состояние';

		protected string $textDeleteConfirm = 'Удалить?';
		protected string $textSetStateConfirm = 'Изменить состояние?';

		protected string $textResponseOkCreate = 'Создано';
		protected string $textResponseOkUpdate = 'Изменено';
		protected string $textResponseOkDelete = 'Удалено';
		protected string $textResponseOkSetState = 'Изменено состояние';

		public string $textBtnCreate = 'Создать';
		public string $textBtnUpdate = 'Изменить';

		protected string $textResponseErrorAccess = 'Ошибка доступа. Недостаточно прав.';
		protected string $textResponseErrorNotFound = 'Элемент не найден';
		protected string $textResponseErrorCreate = 'Ошибка сохранения';
		protected string $textResponseErrorUpdate = 'Ошибка обновления';
		protected string $textResponseErrorDelete = 'Ошибка удаления';
		protected string $textResponseErrorState = 'Ошибка установки состояния';

	}