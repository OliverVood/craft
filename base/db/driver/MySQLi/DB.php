<?php

	namespace Base\DB\Driver\MySQLi;

	require_once DIR_BASE_DB . 'driver/MySQLi/Table.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/Structure.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/Response.php';

	require_once DIR_BASE_DB . 'driver/MySQLi/request/Render.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/request/Select.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/request/Insert.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/request/Update.php';

	use Base\DB\Driver\MySQLi\Request\Select;
	use Base\DB\Driver\MySQLi\Request\Insert;
	use Base\DB\Driver\MySQLi\Request\Update;
	use mysqli;

	/**
	 * Для работы с базой данных mysqli
	 */
	abstract class DB extends \Base\DB\DB {
		protected mysqli $db;

		private int $codeError;

		protected ?string $host;
		protected ?string $dbname;
		protected ?string $username;
		protected ?string $password;
		protected ?string $port;
		protected ?string $socket;

		/**
		 * Создаёт новый экземпляр базы данных
		 * @param string|null $host - Хост
		 * @param string|null $dbname - Наименование БД
		 * @param string|null $username - Пользователь
		 * @param string|null $password - Пароль
		 * @param string|int|null $port - Порт
		 * @param string|null $socket - Сокет
		 */
		protected function __construct(?string $host = null, ?string $dbname = null, ?string $username = null, ?string $password = null, string|int|null $port = null, ?string $socket = null) {
			$this->host = $host;
			$this->dbname = $dbname;
			$this->username = $username;
			$this->password = $password;
			$this->port = $port;
			$this->socket = $socket;

			parent::__construct();

			$this->link();
		}

		/**
		 * Пытается установить соединение с базой данных
		 * @return void
		 */
		protected function link(): void {
			@ $this->db = new mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port, $this->socket);

			if (!$this->db->connect_errno) {
				$this->state = true;
			} else {
				$this->state = false;
				$this->codeError = $this->db->connect_errno;
			}
		}

		/**
		 * Экранирует специальные символы
		 * @param string $text - Текст
		 * @return string
		 */
		public function escape(string $text): string {
			return $this->db->real_escape_string($text);
		}

		/**
		 * Запрос серверу
		 * @param string $query - Текст запроса
		 * @return Response
		 */
		public function query(string $query): Response {
			$this->addToHistory($query);

			$result = $this->db->query($query);

			return new Response($result);
		}

		/**
		 * Выборка данных
		 * @return Select
		 */
		public function select(): Select {
			return new Select($this);
		}

		/**
		 * Добавление данных
		 * @return Insert
		 */
		public function insert(): Insert {
			return new Insert($this);
		}

		/**
		 * Обновление данных
		 * @return Update
		 */
		public function update(): Update {
			return new Update($this);
		}

		/**
		 * Возвращает идентификатор добавленной записи
		 * @return int
		 */
		public function insertId(): int {
			return $this->db->insert_id;
		}

		/**
		 * Инициализация структуры
		 * @return void
		 */
		protected function initStructure(): void {
			$this->structure = new Structure($this, $this->dbname);
		}

	}