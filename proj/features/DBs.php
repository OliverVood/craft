<?php

	declare(strict_types=1);

	namespace Proj\Features;

	use Base\Access\Feature;

	/**
	 * Признак баз данных
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class DBs extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(self::RIGHT_ACCESS_ID, self::RIGHT_ACCESS_NAME, __('Назначение прав'));
			$this->rights->registration(self::RIGHT_CHECK_ID, self::RIGHT_CHECK_NAME,  __('Проверить БД'));
			$this->rights->registration(self::RIGHT_MAKE_ID, self::RIGHT_MAKE_NAME,  __('Исправить БД'));
			$this->rights->registration(self::RIGHT_STRUCTURE_ID, self::RIGHT_STRUCTURE_NAME,  __('Структура БД'));
		}

	}