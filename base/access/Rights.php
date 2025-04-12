<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Exception;
	use Generator;

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

		/**
		 * Перебирает права
		 * @return Generator
		 */
		public function each(): Generator {
			foreach ($this->rights as $right) yield $right->name() => $right;

			return null;
		}

		/**
		 * Проверяет существование права
		 * @param string $name - Наименование права
		 * @return bool
		 */
		public function __isset(string $name): bool {
			return isset($this->rights[$name]);
		}

	}