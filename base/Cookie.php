<?php

	namespace Base;

	/**
	 * Куки
	 */
	class Cookie {
		use Singleton;

		/**
		 * Создаёт / запускает сеанс куки
		 * @return void
		 */
		public function start(): void {  }

		/**
		 * Возвращает данные куки ключу
		 * @param string|null $key - Ключ
		 * @return mixed
		 */
		public function get(?string $key = null): mixed {
			if (is_null($key)) return $_COOKIE ?? null;
			return $_COOKIE[$key] ?? null;
		}

		/**
		 * Проверяет наличие ключа в куки
		 * @param string|null $key - Ключ
		 * @return bool
		 */
		public function isset(?string $key = null): bool {
			if (is_null($key)) return isset($_COOKIE);
			return isset($_COOKIE[$key]);
		}

		/**
		 * Устанавливает куку по ключу
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param int $time - Время жизни
		 * @param string $path - Путь
		 * @return void
		 */
		public function set(string $key, string $value, int $time, string $path = '/'): void {
			setcookie($key, $value, $time, $path);
		}

		/**
		 * Удаляет куку по ключу
		 * @param string $key - Ключ
		 * @param string $path - Путь
		 * @return void
		 */
		public function delete(string $key, string $path = '/'): void {
			setcookie($key, '', time() - 3600, $path);
		}

	}