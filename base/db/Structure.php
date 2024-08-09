<?php

	namespace Base\DB;

	class Structure {
		private array /** @var Table[] */ $tables;

		public function __construct() {

		}

		public function table(string $name, string $description = ''): Table {
			$this->tables[$name] = new Table($name, $description);

			return $this->tables[$name];
		}

	}