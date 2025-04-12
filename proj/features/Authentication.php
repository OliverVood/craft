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
	class Authentication extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(1, 'access', __('Назначение прав'));
		}

	}