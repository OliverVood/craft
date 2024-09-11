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

	require DIR_BASE_DB . 'fields/Line.php';

	require DIR_BASE_DB . 'fields/Timestamp.php';

	class Field {

		/**
		 * Возвращает структуру поля
		 * @return array
		 */
		public function structure(): array {
			return [];
		}

	}