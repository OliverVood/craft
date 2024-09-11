<?php

	namespace Base\DB\Driver\MySQLi\Fields;

	use Base\DB\Driver\MySQLi\Field;

	class UInt32 extends Field {

		public function __construct(string $name, string $description = '') {
			parent::__construct('uint32', $name, $description);
		}

	}