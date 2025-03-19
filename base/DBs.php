<?php

	declare(strict_types=1);

	namespace Base;

	use Base\DB\DB;

	/**
	 * Класс работы с базами данных
	 * @property DB[] $dbs;
	 */
	class DBs {
		private array $dbs = [];

		/**
		 * Регистрирует базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return void
		 */
		public function registration(string $alias): void {
			$this->load($alias);
			$this->init($alias);
		}

		/**
		 * Загружает базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return void
		 */
		public function load(string $alias): void {
			$path = str_replace('.', '/', $alias);
			require_once DIR_PROJ_DB . $path . '.php';
		}

		/**
		 * Инициализирует базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return void
		 */
		private function init(string $alias): void {
			$path = str_replace('.', '\\', $alias);
			$class = "\\Proj\\DB\\{$path}";
			$this->dbs[$alias] = new $class();
		}

		/**
		 * Возвращает базу данных по псевдониму
		 * @param string $alias - Псевдоним базы данных
		 * @return DB
		 */
		private function get(string $alias): DB {
			return $this->dbs[$alias];
		}

		/**
		 * Регистрирует и возвращает базу данных
		 * @param string $alias - Псевдоним базы данных
		 * @return DB
		 */
		public function registrationAndGet(string $alias): DB {
			if (!isset($this->dbs[$alias])) $this->registration($alias);

			return $this->get($alias);
		}

	}