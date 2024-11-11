<?php

	namespace Base\DB\Driver\MySQLi;

	use Generator;
	use mysqli_result;

	/**
	 * Дря работы с результатом запроса к базе данных mysqli
	 */
	class Response extends \Base\DB\Response {
		private bool | mysqli_result $result;

		public function __construct(bool | mysqli_result $result) {
			$this->result = $result;
		}

		/**
		 * Проверяет состояние выполненного запроса
		 * @return bool
		 */
		public function isState(): bool {
			return (bool)$this->result;
		}

		/**
		 * Возвращает результат запроса в виде генератора
		 * @return Generator
		 */
		public function each(): Generator {
			if (!$this->result) return null;

			while ($row = $this->result->fetch_assoc()) yield $row;

			return null;
		}

		/**
		 * Возвращает одну запись
		 * @return array|null
		 */
		public function getOne(): ?array {
			return $this->result->fetch_assoc();
		}

		/**
		 * Возвращает одно поле
		 * @param string $name - Наименование поля, по умолчанию возьмёт первое
		 * @return string|null
		 */
		public function getOneField(string $name = ''): ?string {
			$row = $this->result->fetch_array();
			return ($name === '') ? $row[0] : $row[$name];
		}

	}