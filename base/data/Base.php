<?php

	declare(strict_types=1);

	namespace Base\Data;

	/**
	 * Получение пользовательских данных по ключу
	 */
	abstract class Base {
		private array $data;
		private string $key;

		protected function __construct(array $data) {
			$this->data = $data;
		}

		/**
		 * Задаёт ключ для дальнейшей работы
		 * @param string $key - Ключ
		 * @return void
		 */
		public function key(string $key): void {
			$this->key = $key;
		}

		/**
		 * Если значение существует, то вернёт его преобразовав в логический тип, иначе вернёт значение по умолчанию
		 * @param mixed|null $default - Значение по умолчанию
		 * @return mixed
		 */
		public function bool(mixed $default = null): mixed {
			return isset($this->data[$this->key]) ? (bool)$this->data[$this->key] : $default;
		}

		/**
		 * Если значение существует, то вернёт его преобразовав в целое число, иначе вернёт значение по умолчанию
		 * @param mixed|null $default - Значение по умолчанию
		 * @return mixed
		 */
		public function int(mixed $default = null): mixed {
			return isset($this->data[$this->key]) ? (int)$this->data[$this->key] : $default;
		}

		/**
		 * Если значение существует, то вернёт его преобразовав в строку, иначе вернёт значение по умолчанию
		 * @param mixed|null $default - Значение по умолчанию
		 * @return mixed
		 */
		public function string(mixed $default = null): mixed {
			return isset($this->data[$this->key]) ? (string)$this->data[$this->key] : $default;
		}

		/**
		 * Если значение существует, то вернёт его, иначе вернёт значение по умолчанию
		 * @param mixed|null $default - Значение по умолчанию
		 * @return mixed
		 */
		public function data(mixed $default = null): mixed {
			return $this->data[$this->key] ?? $default;
		}

		/**
		 * Возвращает все данные
		 * @return array
		 */
		public function all(): array {
			return $this->data;
		}

	}