<?php

	namespace Base\DB;

	require_once DIR_BASE_DB . 'Table.php';
	require_once DIR_BASE_DB . 'Structure.php';

	require_once DIR_BASE_DB . 'Response.php';

	require_once DIR_BASE_DB . 'request/Select.php';

	use Base\DB\Request\Select;

	abstract class DB {
		public Structure $structure;

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
		abstract protected function query(string $query): Response;

		/**
		 * Выборка данных
		 * @return Select
		 */
		abstract protected function select(): Select;

		/**
		 * Инициализация структуры
		 * @return void
		 */
		abstract protected function initStructure(): void;

	}