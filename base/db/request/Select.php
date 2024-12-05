<?php

	namespace Base\DB\Request;

	use Base\DB\DB;
	use Base\DB\Response;

	/**
	 * Для запросов SELECT (базовый абстрактный класс)
	 */
	abstract class Select {
		protected ?DB $db;

		protected array $fields			= [];
//		private array $calc				= [];
		protected string $table			= '';
//		private string $join			= '';
		protected array $conditions		= [];
		protected array $order			= [];
//		private array $group			= [];
		protected array $limit			= [null, null];

		public function __construct(DB & $db) {
			$this->db = & $db;
		}

		/**
		 * Задаёт перечень полей
		 * @param ...$fields - Перечень полей
		 * @return $this
		 */
		public function fields(...$fields): self {
			foreach ($fields as $field) $this->fields[] = $field;

			return $this;
		}

//		public function calc(...$strings): self;

		/**
		 * Задаёт таблицу
		 * @param string $table - Таблица
		 * @return self
		 */
		public function table(string $table): self {
			$this->table = $table;

			return $this;
		}

//		public function join(string $join, string $table, string $as = '', string $on = ''): self;

		/**
		 * Задаёт условие с полем и значением
		 * @param string $field - Поле
		 * @param string $value - Значение
		 * @param string $operator - Оператор
		 * @return $this
		 */
		public function where(string $field, string $value, string $operator = '='): self {
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
		 * Задаёт сортировку
		 * @param string $field - Поле
		 * @param string $direction - Направление
		 * @return $this
		 */
		public function order(string $field, string $direction = 'ASC'): self {
			$this->order[] = [$field, $direction];

			return $this;
		}

//		public function group(...$fields): self;

		/**
		 * Задаёт ограничения
		 * @param int $count - Количество записей
		 * @param int|null $skip - Сдвиг
		 * @return $this
		 */
		public function limit(int $count, int $skip = null): self {
			$this->limit = [$count, $skip];

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