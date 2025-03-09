<?php

	namespace Base;

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

	}