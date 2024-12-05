<?php

	namespace Base\DB\Request;


	use Base\DB\DB;
	use Base\DB\Response;

	/**
	 * Для запросов INSERT (базовый абстрактный класс)
	 */
	abstract class Insert {
		protected ?DB $db;

		protected string $table			= '';
		protected array	 $data			= [];

		public function __construct(DB & $db) {
			$this->db = & $db;
		}

		/**
		 * Задаёт таблицу
		 * @param string $table - Таблица
		 * @return self
		 */
		public function table(string $table): self {
			$this->table = $table;

			return $this;
		}

		/**
		 * Задаёт данные
		 * @param array $data - Данные
		 * @return $this
		 */
		public function values(array $data): self {
			$this->data = $data;

			return $this;
		}

		/**
		 * Возвращает текст запроса
		 * @return string
		 */
		abstract public function get(): string;

		/**
		 * Выполняет запрос
		 * @return Response
		 */
		public function query(): Response {
			$query = $this->get();

			return $this->db->query($query);
		}

	}