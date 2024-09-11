<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class UInt8 extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('uint8', $name, $description);
		}

	}