<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Generator;

	/**
	 * Базовый класс признаков
	 */
	class Feature {
		protected int $id;
		protected string $name;
		protected string $title;

		protected Rights $rights;

		/**
		 * @param int $id - Идентификатор признака
		 * @param string $name - Наименование признака
		 * @param $title - Заголовок признака
		 */
		public function __construct(int $id, string $name, string $title = '') {
			$this->id = $id;
			$this->name = $name;
			$this->title = $title ?: $name;

			$this->rights = new Rights();
		}

		/**
		 * Возвращает идентификатор признака
		 * @return int
		 */
		public function id(): int {
			return $this->id;
		}

		/**
		 * Возвращает наименование признака
		 * @return string
		 */
		public function name(): string {
			return $this->name;
		}

		/**
		 * Возвращает заголовок признака
		 * @return string
		 */
		public function title(): string {
			return $this->title;
		}

		/**
		 * Возвращает право
		 * @param string $name - Наименование права
		 * @return Right
		 */
		public function rights(string $name): Right {
			return $this->rights->get($name);
		}

		/**
		 * Возвращает итератор прав
		 * @return Generator
		 */
		public function rightsEach(): Generator {
			return $this->rights->each();
		}

		/**
		 * Проверяет существование права
		 * @param string $name - Наименование права
		 * @return bool
		 */
		public function issetRight(string $name): bool {
			return isset($this->rights->$name);
		}

	}