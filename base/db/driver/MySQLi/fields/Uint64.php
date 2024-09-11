<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class Uint64 extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('uint64', $name, $description);
		}

	}