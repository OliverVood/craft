<?php

	namespace Base\Helper;

	use Exception;

	/**
	 * Криптография
	 */
	abstract class Cryptography {
		/**
		 * Выполняет шифрование
		 * @param $text - Текст
		 * @return string
		 */
		public static function encryption(string $text): string {
			return md5($text);
		}

		/**
		 * Генерирует бинарные данные в шестнадцатеричном представлении
		 * @param int $bytes - Количество байтов
		 * @return string
		 */
		public static function generateBinToHex(int $bytes): string {
			try {
				return bin2hex(random_bytes($bytes));
			} catch (Exception $e) {
				app()->error($e);
			}
		}

	}