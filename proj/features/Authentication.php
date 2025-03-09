<?php

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

//			$this->rights->registration(1, 'read', 'Чтение');
//			$this->rights->registration(2, 'create', 'Создание');
//			$this->rights->registration(3, 'edit', 'Редактирование');
//			$this->rights->registration(4, 'delete', 'Удаление');
		}

	}