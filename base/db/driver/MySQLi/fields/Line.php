<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Line extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('line', $name, $description);
		}

	}