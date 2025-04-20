<?php

	declare(strict_types=1);

	namespace Proj\Features;

	use Base\Access\Feature;

	/**
	 * Признак пользователей
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class Users extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(self::RIGHT_ACCESS_ID, self::RIGHT_ACCESS_NAME, __('Назначение прав'));
			$this->rights->registration(self::RIGHT_SELECT_ID, self::RIGHT_SELECT_NAME, __('Выборка'));
			$this->rights->registration(self::RIGHT_BROWSE_ID, self::RIGHT_BROWSE_NAME, __('Вывод'));
			$this->rights->registration(self::RIGHT_CREATE_ID, self::RIGHT_CREATE_NAME, __('Создание'));
			$this->rights->registration(self::RIGHT_UPDATE_ID, self::RIGHT_UPDATE_NAME, __('Изменение'));
			$this->rights->registration(self::RIGHT_DELETE_ID, self::RIGHT_DELETE_NAME, __('Удаление'));
		}

	}