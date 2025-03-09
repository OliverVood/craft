<?php

	declare(strict_types=1);

	namespace Proj\DB;

	require_once DIR_BASE_DB . 'driver/MySQLi/DB.php';

	use Base\DB\Driver\MySQLi\DB;

	class Craft extends DB {

		public function __construct() {
			parent::__construct('MySQL-8.0', 'craft', 'root', '');
		}

	}