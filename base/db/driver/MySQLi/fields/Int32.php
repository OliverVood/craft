<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Int32 extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('int32', $name, $description);
		}

	}