<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\DB\DB;
	use Base\DB\Response;
	use Exception;
	use Base\DB\Request\{Select, Insert, Update};
	use Proj\DB\Craft;

	/**
	 * Базовый класс для работы с моделями-редакторами
	 */
	class Model extends \Base\Model {
		const STATE_ERROR = 0;
		const STATE_ACTIVE = 1;
		const STATE_INACTIVE = 2;
		const STATE_ARCHIVE = 3;
		const STATE_BLOCK = 4;
		const STATE_DELETE = 100;

		protected DB $db;
		protected string $table;
		protected array $states = [];

		public function __construct(string $db, string $table) {
			parent::__construct();

			$this->db = db($db);
			$this->table = $table;
		}

		public function index(string ...$fields): Response {
			return $this->db
				->select()
				->fields(...$fields)
				->table($this->table)
				->where('state', self::STATE_DELETE, '!=')
				->where('state', self::STATE_ERROR, '!=')
				->query();
		}

		/**
		 * Выборка данных
		 * @param array $fields - Перечень полей для выборки
		 * @param int $page_current - Текущая страница
		 * @param int $page_entries - Количество записей на странице
		 * @return array
		 */
		public function select(array $fields, int $page_current = 1, int $page_entries = 10): array {
			$query = $this->getQuerySelect(...$fields);

			$ext = [];
			if ($page_entries) {
				$start = ($page_current - 1) * $page_entries;
				$response = $this->db->query("SELECT COUNT(*) AS `count` FROM ({$query->get()}) AS `table`");
				$page_records = $response->getOneField('count');

				$ext['page'] = [
					'records' => $page_records,
					'current' => $page_current,
					'count' => (int)ceil($page_records / $page_entries)
				];

				$query->limit($start, $page_entries);
			}

			$response = $this->db->query($query->get());

			return [$response, $ext];
		}

		/**
		 * Выборка одной записи
		 * @param int $id - Идентификатор
		 * @param array $fields - Перечень полей
		 * @return array|null
		 */
		public function browse(int $id, array $fields): ?array {
			$query = $this->getQueryBrowse($id, ...$fields);
			$response = $this->db->query($query->get());

			return $response->getOne();
		}

		/**
		 * Создание записи
		 * @param array $data - Данные
		 * @return int
		 */
		public function create(array $data): int {
			$this->prepareCreate($data);

			$query = $this->getQueryCreate($data);
			try {
				$this->db->query($query->get());
			} catch (Exception) {
				return false;
			}

			return $this->db->insertId();
		}

		/**
		 * Обновление записи
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function update(array $data, int $id): bool {
			$this->prepareUpdate($data, $id);

			$query = $this->getQueryUpdate($data, $id);
			try {
				$this->db->query($query->get());
			} catch (Exception) {
				return false;
			}

			return true;
		}

		/**
		 * Удаление записи
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function delete(int $id): bool {
			$this->prepareDelete($id);

			$query = $this->getQueryDelete($id);
			try {
				$this->db->query($query->get());
			} catch (Exception) {
				return false;
			}

			return true;
		}

		/**
		 * Обновляет состояние
		 * @param int $id - Идентификатор
		 * @param int $state - Состояние
		 * @return bool
		 */
		public function setState(int $id, int $state): bool {
			$oldState = $this->getState($id);

			$this->prepareSetState($id, $state, $oldState);

			if (!$this->checkAccessState($oldState, $state)) return false;

			$query = $this->getQuerySetState($id, $state, $oldState);
			try {
				$this->db->query($query->get());
			} catch (Exception) {
				return false;
			}

			return true;
		}

		/**
		 * Возвращает состояние
		 * @param int $id - Идентификатор
		 * @return int
		 */
		protected function getState(int $id): int {
			$query = $this->getQueryState($id);
			$response = $this->db->query($query->get());
			return $response->getOneField('state');
		}

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		protected function prepareCreate(array & $data): void {  }

		/**
		 * Подготовка данных перед изменением
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		protected function prepareUpdate(array & $data, int $id): void {  }

		/**
		 * Подготовка данных перед удалением
		 * @param int $id - Идентификатор
		 * @return void
		 */
		protected function prepareDelete(int $id): void {  }

		/**
		 * Подготовка данных перед изменением состояния
		 * @param int $id - Идентификатор
		 * @param int $state - Состояние
		 * @param int $oldState - Старое состояние
		 * @return void
		 */
		protected function prepareSetState(int $id, int $state, int $oldState): void {  }

		/**
		 * Возвращает запрос на выборку данных
		 * @param string ...$fields - Перечень полей
		 * @return Select
		 */
		protected function getQuerySelect(string ...$fields): Select {
			return $this->db
				->select()
				->fields(...$fields)
				->table($this->table)
				->where('state', self::STATE_DELETE, '!=')
				->where('state', self::STATE_ERROR, '!=')
				->order('id');
		}

		/**
		 * Возвращает запрос на выборку одной записи
		 * @param int $id - Идентификатор
		 * @param string ...$fields - Перечень полей
		 * @return Select
		 */
		protected function getQueryBrowse(int $id, string ...$fields): Select {
			return $this->db
				->select()
				->fields(...$fields)
				->table($this->table)
				->where('id', $id)
				->where('state', self::STATE_DELETE, '!=')
				->where('state', self::STATE_ERROR, '!=');
		}

		/**
		 * Возвращает запрос на создание записи
		 * @param array $data - Данные
		 * @return Insert
		 */
		protected function getQueryCreate(array $data): Insert {
			return $this->db
				->insert()
				->table($this->table)
				->values($data);
		}

		/**
		 * Возвращает запрос на обновление записи
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return Update
		 */
		protected function getQueryUpdate(array $data, int $id): Update {
			return $this->db
				->update()
				->table($this->table)
				->values($data)
				->where('id', $id);
		}

		/**
		 * Возвращает запрос на удаление записи
		 * @param int $id - Идентификатор
		 * @return Update
		 */
		protected function getQueryDelete(int $id): Update {
			return $this->db
				->update()
				->table($this->table)
				->values(['state' => self::STATE_DELETE])
				->where('id', $id);
		}

		/**
		 * Возвращает запрос на выборку состояния
		 * @param int $id - Идентификатор
		 * @return Select
		 */
		protected function getQueryState(int $id): Select {
			return $this->db
				->select()
				->fields('state')
				->table($this->table)
				->where('id', $id);
		}

		/**
		 * Возвращает запрос на обновление состояния
		 * @param int $id - Идентификатор
		 * @param int $state - Состояние
		 * @param int $oldState - Старое состояние
		 * @return Update
		 */
		protected function getQuerySetState(int $id, int $state, int $oldState): Update {
			return $this->db
				->update()
				->table($this->table)
				->values(['state' => $state])
				->where('id', $id)
				->where('state', $oldState);
		}

		/**
		 * Проверяет доступность изменения состояния
		 * @param int $from
		 * @param int $to
		 * @return bool
		 */
		protected function checkAccessState(int $from, int $to): bool {
			return (isset($this->states[$from]) && in_array($to, $this->states[$from]));
		}

	}