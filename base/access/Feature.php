<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Generator;

	/**
	 * Базовый класс признаков
	 */
	class Feature {
		const RIGHT_ACCESS_ID = 1;
		const RIGHT_SELECT_ID = 2;
		const RIGHT_BROWSE_ID = 3;
		const RIGHT_CREATE_ID = 4;
		const RIGHT_UPDATE_ID = 5;
		const RIGHT_DELETE_ID = 6;
		const RIGHT_STATUS_ID = 7;
		const RIGHT_CHECK_ID = 10;
		const RIGHT_MAKE_ID = 11;
		const RIGHT_STRUCTURE_ID = 12;

		const RIGHT_ACCESS_NAME = 'access';
		const RIGHT_SELECT_NAME = 'select';
		const RIGHT_BROWSE_NAME = 'browse';
		const RIGHT_CREATE_NAME = 'create';
		const RIGHT_UPDATE_NAME = 'update';
		const RIGHT_DELETE_NAME = 'delete';
		const RIGHT_STATUS_NAME = 'status';
		const RIGHT_CHECK_NAME = 'check';
		const RIGHT_MAKE_NAME = 'make';
		const RIGHT_STRUCTURE_NAME = 'structure';

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