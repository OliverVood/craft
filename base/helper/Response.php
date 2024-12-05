<?php

	namespace Base\Helper;

	use Base\Link\Internal as Link;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Ответы от сервера
	 */
	class Response {
		private static array $stack = [];

		/**
		 * Добавляет контент в секции в стек ответов
		 * @param string $section - Секция
		 * @param string $html - Контент
		 * @param bool $empty - Очистить ли секцию перед вставкой
		 * @return void
		 */
		public static function pushSection(string $section, string $html, bool $empty = true): void {
			self::push('section', ['section' => $section, 'html' => $html, 'empty' => $empty]);
		}

		/**
		 * Добавляет историю в стек ответов
		 * @param Link $action - Действие
		 * @param array $data - Данные
		 * @param string|null $handler - Обработчик
		 * @return void
		 */
		public static function pushHistory(Link $action, array $data = [], string $handler = null): void {
			if (input('no_history')) return;
			self::Push('history', ['address' => $action->href($data), 'xhr' => $action->xhr($data), 'handler' => $handler]);
		}

		/**
		 * Добавляет уведомление об успехе в стек ответов
		 * @param string $notice - Текст сообщения
		 * @return void
		 */
		public static function pushNoticeOk(string $notice): void {
			self::PushNotice('ok', $notice);
		}

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

		/**
		 * Добавляет данные в стек ответов
		 * @param $data - Данные
		 * @return void
		 */
		public static function pushData($data): void {
			self::Push('data', $data);
		}

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

		/**
		 * Отправляет массив данных
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public static function sendData(array $data): void {
			self::$stack = [];
			self::pushData($data);
			self::sendJSON();
		}

	}