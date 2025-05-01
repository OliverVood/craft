<?php

	declare(strict_types=1);

	namespace Proj\Features;

	use Base\Access\Feature;

	/**
	 * Признак аутентификации
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class Craft extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(self::RIGHT_ACCESS_ID, self::RIGHT_ACCESS_NAME, __('Назначение прав'));
			$this->rights->registration(self::RIGHT_UPDATE_ID, self::RIGHT_UPDATE_NAME, __('Изменение'));
		}

	}