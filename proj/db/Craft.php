<?php

	declare(strict_types=1);

	namespace Proj\DB;

	require_once DIR_BASE_DB . 'driver/MySQLi/DB.php';

	use Base\DB\Driver\MySQLi\DB;

	class Craft extends DB {

		public function __construct() {
			parent::__construct(env('DB_CRAFT_HOST'), env('DB_CRAFT_NAME'), env('DB_CRAFT_USER'), env('DB_CRAFT_PASS'));
		}

	}