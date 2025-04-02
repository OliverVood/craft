<?php

	declare(strict_types=1);

	namespace Proj\Features;

	use Base\Access\Feature;

	/**
	 * Признак групп
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class Groups extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(1, 'access', __('Назначение прав'));
			$this->rights->registration(2, 'select', __('Выборка'));
			$this->rights->registration(3, 'browse', __('Вывод'));
			$this->rights->registration(4, 'create', __('Создание'));
			$this->rights->registration(5, 'update', __('Изменение'));
			$this->rights->registration(6, 'delete', __('Удаление'));
		}

	}