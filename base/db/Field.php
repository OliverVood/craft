<?php

	namespace Base\DB;

	require DIR_BASE_DB . 'fields/Boolean.php';

	require DIR_BASE_DB . 'fields/Int8.php';
	require DIR_BASE_DB . 'fields/Int16.php';
	require DIR_BASE_DB . 'fields/Int24.php';
	require DIR_BASE_DB . 'fields/Int32.php';
	require DIR_BASE_DB . 'fields/Int64.php';

	require DIR_BASE_DB . 'fields/UInt8.php';
	require DIR_BASE_DB . 'fields/UInt16.php';
	require DIR_BASE_DB . 'fields/UInt24.php';
	require DIR_BASE_DB . 'fields/UInt32.php';
	require DIR_BASE_DB . 'fields/UInt64.php';

	require DIR_BASE_DB . 'fields/RealFloat.php';
	require DIR_BASE_DB . 'fields/RealDouble.php';

	require DIR_BASE_DB . 'fields/StringText.php';
	require DIR_BASE_DB . 'fields/Text.php';

	require DIR_BASE_DB . 'fields/Timestamp.php';

	require DIR_BASE_DB . 'fields/Enum.php';
	require DIR_BASE_DB . 'fields/Set.php';

	require DIR_BASE_DB . 'fields/ID.php';

	/**
	 * Для работы с полями таблицы (базовый абстрактный класс)
	 */
	abstract class Field {
		const ACTION_OK			=  1;
		const ACTION_CREATE 	= -1;
		const ACTION_UPDATE		= -2;
		const ACTION_DELETE		= -4;

		protected DB $db;
		protected string $type;
		protected string $name;
		protected string $description;

		protected function __construct(DB $db, string $type, string $name, string $description = '') {
			$this->db = $db;
			$this->type = $type;
			$this->name = $name;
			$this->description = $description;
		}

		/**
		 * Возвращает структуру поля
		 * @return array
		 */
		public function structure(): array {
			return [];
		}

		/**
		 * Проверка поля
		 * @param array $data - Данные
		 * @return bool
		 */
		abstract public function check(array $data): bool;

		/**
		 * Создаёт поле
		 * @param string $tableName - Наименование таблицы
		 * @return bool
		 */
		abstract protected function create(string $tableName): bool;

		/**
		 * Обновляет поле
		 * @param string $tableName - Наименование таблицы
		 * @return bool
		 */
		abstract protected function update(string $tableName): bool;

	}