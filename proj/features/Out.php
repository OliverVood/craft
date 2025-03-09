<?php

	namespace Proj\Features;

	use Base\Access\Feature;

	/**
	 * Признак вывода
	 * @param int $id - Идентификатор
	 * @param string $name - Наименование
	 * @param string $title - Заголовок
	 */
	class Out extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);
		}

	}