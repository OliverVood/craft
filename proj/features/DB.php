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
	class DB extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(1, 'check', 'Проверить БД');
			$this->rights->registration(2, 'make', 'Исправить БД');
			$this->rights->registration(3, 'structure', 'Структура БД');
		}

	}