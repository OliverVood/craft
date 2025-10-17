<?php

	namespace Base;

	/**
	 * Сессия
	 */
	class Session {
		use Singleton;

		/**
		 * Создаёт / запускает сеанс сессии
		 * @return void
		 */
		public function start(): void {
			session_start();
		}

		/**
		 * Возвращает данные сессии по вложенным ключам
		 * @param string ...$keys - Перечень ключей
		 * @return mixed
		 */
		public function get(string ...$keys): mixed {
			if (!$keys) return $_SESSION;

			$out = $_SESSION;
			foreach ($keys as $key) {
				if (!isset($out[$key])) return null;
				$out = $out[$key];
			}

			return $out;
		}

		/**
		 * Проверяет наличие ключа в сессии
		 * @param string ...$keys - Перечень ключей
		 * @return bool
		 */
		public function isset(string ...$keys): bool {
			if (!$keys) return isset($_SESSION);

			$out = $_SESSION;
			foreach ($keys as $key) {
				if (!isset($out[$key])) return false;
				$out = $out[$key];
			}

			return true;
		}

		/**
		 * Устанавливает данные сессии по вложенным ключам
		 * @param mixed $value - Значение
		 * @param string ...$keys - Перечень ключей
		 * @return void
		 */
		public function set(mixed $value, string ...$keys): void {
			if (!$keys) return;

			$out = & $_SESSION;
			$nesting = count($keys);
			$i = 0;
			foreach ($keys as $key) {
				$i++;
				if (isset($out[$key]) && !is_array($out[$key])) {
					if ($nesting == $i) {
						$out[$key] = $value;
					}
					return;
				}
				if (!isset($out[$key])) $out[$key] = [];
				$out = & $out[$key];
			}

			$out = $value;
		}

		/**
		 * Удаляет данные сессии по вложенным ключам
		 * @param string ...$keys - Перечень ключей
		 * @return void
		 */
		public function delete(string ...$keys): void {
			if (!$keys) {
				session_unset();
				return;
			}

			$out = & $_SESSION;
			$nesting = count($keys);
			$i = 0;
			foreach ($keys as $key) {
				$i++;
				if (!isset($out[$key])) return;
				if ($nesting == $i) break;

				$out = & $out[$key];
			}

			unset($out[$keys[$nesting - 1]]);
		}

	}