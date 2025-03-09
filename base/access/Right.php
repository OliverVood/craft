<?php

	declare(strict_types=1);

	namespace Base\Access;

	/**
	 * Базовый класс право
	 */
	class Right {
		private int $id;
		private string $name;
		private string $title;

		/**
		 * @param int $id - Идентификатор права
		 * @param string $name - Наименование права
		 * @param string $title - Заголовок права
		 */
		public function __construct(int $id, string $name, string $title = '') {
			$this->id = $id;
			$this->name = $name;
			$this->title = $title ?: $name;
		}

		/**
		 * Возвращает идентификатор права
		 * @return int
		 */
		public function id(): int {
			return $this->id;
		}

	}