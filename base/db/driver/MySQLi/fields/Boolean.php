<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Boolean extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('bool', $name, $description);
		}

	}