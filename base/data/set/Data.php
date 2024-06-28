<?php

	namespace Base\Data\Set;

	abstract class Data {
		private array $data;
		private string $key;

		protected function __construct($data) {
			$this->data = $data;
		}

		public function key(string $key): void {
			$this->key = $key;
		}

		public function bool(int $default = null): ?string {
			return isset($this->data[$this->key]) ? (bool)$this->data[$this->key] : $default;
		}

		public function int(int $default = null): ?string {
			return isset($this->data[$this->key]) ? (int)$this->data[$this->key] : $default;
		}

		public function string(string $default = null): ?string {
			return isset($this->data[$this->key]) ? (string)$this->data[$this->key] : $default;
		}

		public function data(string $default = null): mixed {
			return $this->data[$this->key] ?? $default;
		}

	}