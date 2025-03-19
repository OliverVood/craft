<?php

	namespace Base\DB;

	require_once DIR_BASE_DB . 'Table.php';
	require_once DIR_BASE_DB . 'Structure.php';

	require_once DIR_BASE_DB . 'Response.php';

	require_once DIR_BASE_DB . 'request/Select.php';
	require_once DIR_BASE_DB . 'request/Insert.php';
	require_once DIR_BASE_DB . 'request/Update.php';

	use Base\DB\Request\Select;
	use Base\DB\Request\Insert;
	use Base\DB\Request\Update;

	/**
	 * Для работы с базой данных (базовый абстрактный класс)
	 */
	abstract class DB {
		protected Structure $structure;

		protected array $history = [];

		protected bool $state;

		protected function __construct() {
			$this->initStructure();
		}

		/**
		 * Возвращает состояние соединения
		 * @return bool
		 */
		public function isConnect() :bool { return $this->state; }

		/**
		 * Возвращает структуру базы данных
		 * @return Structure
		 */
		public function structure(): Structure { return $this->structure; }

		/**
		 * Добавляет текст запроса в историю
		 * @param string $query - Текст запроса
		 * @return void
		 */
		protected function addToHistory(string $query): void {
			$this->history[self::class][] = $query;
		}

		/**
		 * Пытается установить соединение с базой данных
		 * @return void
		 */
		abstract protected function link(): void;

		/**
		 * Экранирует специальные символы
		 * @param string $text - Текст
		 * @return string
		 */
		abstract protected function escape(string $text): string;

		/**
		 * Запрос серверу
		 * @param string $query - Текст запроса
		 * @return Response
		 */
		abstract public function query(string $query): Response;

		/**
		 * Выборка данных
		 * @return Select
		 */
		abstract protected function select(): Select;

		/**
		 * Добавление данных
		 * @return Insert
		 */
		abstract protected function insert(): Insert;

		/**
		 * Обновление данных
		 * @return Update
		 */
		abstract protected function update(): Update;

		/**
		 * Возвращает идентификатор добавленной записи
		 * @return int
		 */
		abstract protected function insertId(): int;

		/**
		 * Инициализация структуры
		 * @return void
		 */
		abstract protected function initStructure(): void;

	}