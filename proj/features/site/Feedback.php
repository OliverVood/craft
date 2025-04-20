<?php

	declare(strict_types=1);

	namespace Proj\Features\Site;

	use Base\Access\Feature;

	/**
	 * Признак обратной связи
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class Feedback extends Feature {
		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(self::RIGHT_ACCESS_ID, self::RIGHT_ACCESS_NAME, __('Назначение прав'));
			$this->rights->registration(self::RIGHT_SELECT_ID, self::RIGHT_SELECT_NAME, __('Выборка'));
			$this->rights->registration(self::RIGHT_BROWSE_ID, self::RIGHT_BROWSE_NAME, __('Вывод'));
			$this->rights->registration(self::RIGHT_DELETE_ID, self::RIGHT_DELETE_NAME, __('Удаление'));
			$this->rights->registration(self::RIGHT_STATUS_ID, self::RIGHT_STATUS_NAME, __('Изменение состояния'));
		}

	}