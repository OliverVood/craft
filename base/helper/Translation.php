<?php

	namespace Base\Helper;

	/**
	 * Перевод
	 */
	abstract class Translation {
		/**
		 * Возвращает перевод
		 * @param string $alias - Псевдоним
		 * @param array $params - Параметры
		 * @return string
		 */
		public static function get(string $alias, array $params = []): string {
			return $params ? self::prepare($alias, $params) : $alias;
		}

		/**
		 * Подготавливает текст делая постановки
		 * @param string $text - Текст
		 * @param array $params - Параметры замены
		 * @return string
		 */
		public static function prepare(string $text, array $params = []): string {
			foreach ($params as $key => $value) $text = str_replace(":[$key]", $value, $text);
			return $text;
		}

	}