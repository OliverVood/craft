<?php

	namespace Base;

	use Exception;

	/**
	 * Класс конфигурации
	 */
	class Config {
		private array $env = [];

		/**
		 * Загружает конфигурацию
		 * @param string $name - Наименование
		 * @return void
		 */
		public function load(string $name): void {
			$file = DIR_CONFIGS . $name . '.env';

			if (!file_exists($file)) app()->error(new Exception("Configuration file '{$name}' not found"));

			$resource = fopen($file, 'r');
			while (($row = fgets($resource)) !== false) {
				$row = trim($row);

				if ($row === '' || $row[0] === '#') continue;

				$data = explode('=', $row);

				if (count($data) != 2) app()->error(new Exception("Error reading from config file '{$name}'"));

				$key = trim($data[0]);
				$value = match ($data[1]) {
					'true' => true,
					'false' => false,
					'null' => null,
					default => trim($data[1]),
				};

				if (isset($this->env[$key])) app()->error(new Exception("Duplicate key '{$key}' in config file '{$name}'"));

				$this->set($key, $value);
			}
		}

		/**
		 * @param $key - Ключ
		 * @param $value - Значение
		 * @return void
		 */
		private function set($key, $value): void {
			$this->env[$key] = $value;
		}

		/**
		 * @param $key - Ключ
		 * @param $default - Значение по умолчанию
		 * @return mixed
		 */
		public function get($key, $default = null): mixed {
			return $this->env[$key] ?? $default;
		}

	}