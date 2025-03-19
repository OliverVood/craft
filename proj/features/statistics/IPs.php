<?php

	namespace Proj\Features\Statistics;

	use Base\Access\Feature;

	/**
	 * Признак статистики IP
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class IPs extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(1, 'access', __('Назначение прав'));
			$this->rights->registration(2, 'select', __('Выборка'));
		}

	}