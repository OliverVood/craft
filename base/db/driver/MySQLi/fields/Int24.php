<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Int24 extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('int24', $name, $description);
		}

	}