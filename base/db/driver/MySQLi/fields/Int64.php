<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Int64 extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('int64', $name, $description);
		}

	}