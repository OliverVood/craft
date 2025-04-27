<?php

	namespace Base\Helper;

	use Exception;

	/**
	 * Криптография
	 */
	abstract class Security {
		/**
		 * Выполняет шифрование
		 * @return string
		 */
		public static function csrf(): string {
			try {
				return bin2hex(random_bytes(24));
			} catch (Exception $e) {
				app()->error($e);
			}
		}

	}