<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Exception;

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
			try {
				if (!isset($this->rights[$name])) throw new Exception("Right '{$name}' not found");
			} catch (Exception $e) {
				app()->error($e);
			}
			return $this->rights[$name];
		}

	}