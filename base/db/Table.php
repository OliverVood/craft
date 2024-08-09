<?php

	namespace Base\DB;

	class Table {
		protected string $name;
		protected string $description;
		protected array /** @var Field[] */ $fields;

		public function __construct(string $name, string $description = '') {
			$this->$name = $name;
			$this->description = $description;

			$this->fields = [];
		}

		public function id(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int32($name, $description); return $this->fields[$name]; }
		public function bool(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Boolean($name, $description); return $this->fields[$name]; }
		public function int8(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int8($name, $description); return $this->fields[$name]; }
		public function int16(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int16($name, $description); return $this->fields[$name]; }
		public function int24(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int24($name, $description); return $this->fields[$name]; }
		public function int32(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int32($name, $description); return $this->fields[$name]; }
		public function int64(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\Int64($name, $description); return $this->fields[$name]; }
		public function uint8(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt8($name, $description); return $this->fields[$name]; }
		public function uint16(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt16($name, $description); return $this->fields[$name]; }
		public function uint24(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt24($name, $description); return $this->fields[$name]; }
		public function uint32(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt32($name, $description); return $this->fields[$name]; }
		public function uint64(string $name, string $description = ''): Field { $this->fields[$name] = new Fields\UInt64($name, $description); return $this->fields[$name]; }
		public function string(string $name, int $length, string $description = ''): Field { $this->fields[$name] = new Fields\Line($name, $description); return $this->fields[$name]; }
		public function timestamp(string $name, bool $update = false, string $description = ''): Field { $this->fields[$name] = new Fields\Timestamp($name, $description); return $this->fields[$name]; }
	}