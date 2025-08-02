<?php

	namespace Base\Craft;

	/**
	 * Craft. Класс сообщений
	 */
	class Message {
		const TYPE_INFO		= 'info';
		const TYPE_SUCCESS	= 'success';
		const TYPE_WARNING	= 'warning';
		const TYPE_ERROR	= 'error';

		private static array $messages = [];

		/**
		 * Возвращает массив сообщений
		 * @return array
		 */
		public static function get(): array {
			return self::$messages;
		}

		/**
		 * Добавляет информационное сообщение
		 * @param string $message - Сообщение
		 * @return void
		 */
		static public function info(string $message): void {
			self::message(self::TYPE_INFO, $message);
		}

		/**
		 * Добавляет сообщение об успехе
		 * @param string $message - Сообщение
		 * @return void
		 */
		static public function success(string $message): void {
			self::message(self::TYPE_SUCCESS, $message);
		}

		/**
		 * Добавляет предупреждение
		 * @param string $message - Сообщение
		 * @return void
		 */
		static public function warning(string $message): void {
			self::message(self::TYPE_WARNING, $message);
		}

		/**
		 * Добавляет сообщение об ошибке
		 * @param string $message - Сообщение
		 * @param array $data - Данные
		 * @return void
		 */
		static public function error(string $message, array $data = []): void {
			self::message(self::TYPE_ERROR, $message, $data);
		}

		/**
		 * Добавляет сообщение
		 * @param string $type - Тип
		 * @param string $message - Сообщение
		 * @param array $data - Данные
		 * @return void
		 */
		static private function message(string $type, string $message, array $data = []): void {
			self::$messages[] = ['type' => $type, 'message' => $message, 'data' => $data];
		}

	}