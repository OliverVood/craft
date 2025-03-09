<?php

	declare(strict_types=1);

	namespace Base\Access;

	/**
	 * Базовый класс прав
	 */
	class Rights {
		public array $rights = [];

		/**
		 * Регистрирует право
		 * @param int $id - Идентификатор права
		 * @param string $name - Наименование права
		 * @param string $title - Заголовок права
		 * @return void
		 */
		public function registration(int $id, string $name, string $title): void {
			$this->rights[$name] = new Right($id, $name, $title);
		}

		/**
		 * Возвращает право
		 * @param string $name - Наименование права
		 * @return Right
		 */
		public function get(string $name): Right {
			return $this->rights[$name];
		}

	}