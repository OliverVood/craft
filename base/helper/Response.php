<?php

	namespace Base\Helper;

	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Ответы от сервера
	 */
	class Response {
		private static array $stack = [];

//		public static function PushSection(string $section, string $html, bool $empty = true): void {
//			self::Push('section', ['section' => $section, 'html' => $html, 'empty' => $empty]);
//		}
//
//		public static function PushHistory(Action $action, array $data = [], string $handler = null): void {
//			if (GetInt('no_history')) return;
//			self::Push('history', ['address' => $action->GetAddress($data), 'xhr' => $action->GetXHR($data), 'handler' => $handler]);
//		}
//
//		public static function PushNoticeOk(string $notice): void {
//			self::PushNotice('ok', $notice);
//		}
//
//		public static function PushNoticeInfo(string $notice): void {
//			self::PushNotice('info', $notice);
//		}

		/**
		 * Добавляет уведомление об ошибке в стек ответов
		 * @param string $notice - Текст сообщения
		 * @return void
		 */
		public static function pushNoticeError(string $notice): void {
			self::pushNotice('error', $notice);
		}

		/**
		 * Добавляет уведомление в стек ответов
		 * @param string $type - Тип уведомления
		 * @param string $notice - Текст сообщения
		 * @return void
		 */
		private static function pushNotice(string $type, string $notice): void {
			self::push('notice', ['type' => $type, 'notice' => $notice]);
		}

//		public static function PushData($data): void {
//			self::Push('data', $data);
//		}

		/**
		 * Добавляет ответ в стек
		 * @param string $type - Тип ответа
		 * @param array $data - Массив данных
		 * @return void
		 */
		private static function push(string $type = '', array $data = []): void {
			self::$stack[] = ['type' => $type, 'data' => $data];
		}

		/**
		 * Отправляет стек ответов в формате JSON
		 * @return void
		 */
		#[NoReturn] public static function sendJSON(): void {
//			if (DEBUGGER) self::$stack[] = ['type' => 'debugger', 'data' => \Base\Debugger::Get()];
			self::sendJSONData(self::$stack);
		}

		/**
		 * Отправляет массив данных в JSON формате
		 * @param array $data - Массив данных
		 * @return void
		 */
		#[NoReturn] private static function sendJSONData(array $data): void {
			self::sendJSONDo(json_encode($data));
		}

		/**
		 * Выводит JSON в качестве ответа от сервера
		 * @param string $string - Строка JSON
		 * @return void
		 */
		#[NoReturn] private static function sendJSONDo(string $string): void {
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header('Content-Type: application/json; charset=utf-8');
			die($string);
		}

		/**
		 * Отправляет сообщение об ошибке
		 * @param string $notice - Текст сообщения
		 * @return void
		 */
		#[NoReturn] public static function sendNoticeError(string $notice):void {
			self::$stack = [];
			self::pushNoticeError($notice);
			self::sendJSON();
		}

	}