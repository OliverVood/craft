<?php

	declare(strict_types=1);

	namespace Base\DB\Request;

	use Base\DB\DB;
	use Base\DB\Response;

	/**
	 * Для запросов UPDATE (базовый абстрактный класс)
	 */
	abstract class Update {
		protected ?DB $db;

		protected string $table			= '';
		protected array $data			= [];
		protected array $conditions		= [];

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
		 * Задаёт условие с полем и значением
		 * @param string $field - Поле
		 * @param string|int $value - Значение
		 * @param string $operator - Оператор
		 * @return $this
		 */
		public function where(string $field, string|int $value, string $operator = '='): self {
			$this->addConditions('where', 'AND', ['field' => $field, 'value' => $value, 'operator' => $operator]);

			return $this;
		}

		/**
		 * Задаёт условие с двумя полями
		 * @param string $field1 - Первое поле
		 * @param string $field2 - Второе поле
		 * @param string $operator - Оператор
		 * @return $this
		 */
		public function compare(string $field1, string $field2, string $operator = '='): self {
			$this->addConditions('compare', 'AND', ['field1' => $field1, 'field2' => $field2, 'operator' => $operator]);

			return $this;
		}

		/**
		 * Добавляет условия
		 * @param string $type - Тип условия
		 * @param string $connection - Соединение условий
		 * @param array $data - Данные
		 * @return void
		 */
		private function addConditions(string $type, string $connection, array $data): void {
			$this->conditions[] = ['type' => $type, 'connection' => $connection, 'data' => $data];
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