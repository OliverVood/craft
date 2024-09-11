<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Timestamp extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('timestamp', $name, $description);
		}

	}