<?php

	declare(strict_types=1);

	namespace Base\Helper;

	use Base\Link\Internal;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Ответы от сервера
	 */
	class Response {
		const TYPE_DATA = 'data';
		const TYPE_SECTION = 'sections';
		const TYPE_HISTORY = 'history';
		const TYPE_NOTICE = 'notice';
//		const TYPE_ERRORS = 'errors';
//
//		const TYPE_NOTICE_OK = 'ok';
//		const TYPE_NOTICE_INFO = 'info';
//		const TYPE_NOTICE_ERROR = 'error';
//
//		private static array $stack = [];
		private array $response = [];

		/**
		 * Код 200. Успех.
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public function ok(array $data = []): void {
			if ($data) $this->data($data);
			$this->send(200);
		}

		/**
		 * Код 201. Создано.
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public function created(array $data = []): void {
			if ($data) $this->data($data);
			$this->send(201);
		}

		/**
		 * Код 202. Запрос получен, но ещё не обработан.
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public function accepted(array $data = []): void {
			if ($data) $this->data($data);
			$this->send(202);
		}

		/**
		 * Код 400. Запрос неправильный. Ошибка возникает в случае, если браузер клиента отправляет некорректный запрос серверу.
		 * @param string $notice - Оповещение
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public function badRequest(string $notice = '', array $data = []): void {
			if ($notice) $this->notice($notice);
			if ($data) $this->data($data);
			$this->send(400);
		}

		/**
		 * Код 401. Ошибка аутентификации.
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function unauthorized(string $notice = ''): void {
			if ($notice) $this->notice($notice);
			$this->send(401);
		}

		/**
		 * Код 403. Ошибка авторизации.
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function forbidden(string $notice = ''): void {
			if ($notice) $this->notice($notice);
			$this->send(403);
		}

		/**
		 * Код 404. Страница или контент не найден.
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function notFound(string $notice = ''): void {
			if ($notice) $this->notice($notice);
			$this->send(404);
		}

		/**
		 * Код 422. Запрос корректен с точки зрения синтаксиса, но его выполнение невозможно. Ошибка валидации.
		 * @param string $notice - Оповещение
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public function unprocessableEntity(string $notice = '', array $data = []): void {
			if ($notice) $this->notice($notice);
			if ($data) $this->data($data);
			$this->send(422);
		}

		/**
		 * Отправляет ответ в формате JSON
		 * @param int $code - Код
		 * @return void
		 */
		#[NoReturn] private function send(int $code): void {
			http_response_code($code);
			$this->sendJSON($this->response);
		}

		/**
		 * Отправляет данные в формате JSON
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] private function sendJSON(array $data): void {
			header("Cache-Control: no-cache, no-store, must-revalidate");
			header('Content-Type: application/json; charset=utf-8');
			die(json_encode($data));
		}

		/**
		 * Добавляет данные в ответ
		 * @param $data - Данные
		 * @return void
		 */
		public function data(mixed $data): void {
			$this->set(self::TYPE_DATA, $data);
		}

		/**
		 * Добавляет контент в секции в стек ответов
		 * @param string $section - Секция
		 * @param string $html - Контент
		 * @param bool $empty - Очистить ли секцию перед вставкой
		 * @return void
		 */
		public function section(string $section, string $html, bool $empty = true): void {
			$this->push(self::TYPE_SECTION, ['name' => $section, 'html' => $html, 'empty' => $empty]);
		}

		/**
		 * Добавляет историю в стек ответов
		 * @param Internal $action - Действие
		 * @param array $data - Данные
//		 * @param string|null $handler - Обработчик
		 * @return void
		 */
		public function history(Internal $action, array $data = []/*, string $handler = null*/): void {
//			if (input('no_history')) return;
			$this->set(self::TYPE_HISTORY, ['address' => $action->href($data), 'xhr' => $action->xhr($data)/*, 'handler' => $handler*/]);
		}

		/**
		 * Добавляет оповещение в ответ
		 * @param string $notice - Данные
		 * @return void
		 */
		public function notice(string $notice): void {
			$this->set(self::TYPE_NOTICE, $notice);
		}

		/**
		 * Добавляет в ответ
		 * @param string $type - Тип ответа
		 * @param mixed $data - Массив данных
		 * @return void
		 */
		private function push(string $type, mixed $data): void {
			$this->response[$type][] = $data;
		}

		private function set(string $type, mixed $data): void {
			$this->response[$type] = $data;
		}

//		/**
//		 * Добавляет уведомление об успехе в стек ответов
//		 * @param string $notice - Текст сообщения
//		 * @return void
//		 */
//		public static function pushNoticeOk(string $notice): void {
//			self::pushNotice(self::TYPE_NOTICE_OK, $notice);
//		}
//
////		public static function PushNoticeInfo(string $notice): void {
////			self::PushNotice('info', $notice);
////		}
//
//		/**
//		 * Добавляет уведомление об ошибке в стек ответов
//		 * @param string $notice - Текст сообщения
//		 * @return void
//		 */
//		public static function pushNoticeError(string $notice): void {
//			self::pushNotice(self::TYPE_NOTICE_ERROR, $notice);
//		}
//
//		/**
//		 * Добавляет уведомление в стек ответов
//		 * @param string $type - Тип уведомления
//		 * @param string $notice - Текст сообщения
//		 * @return void
//		 */
//		private static function pushNotice(string $type, string $notice): void {
//			self::push(self::TYPE_NOTICE, ['type' => $type, 'notice' => $notice]);
//		}
//
//		/**
//		 * Добавляет ошибки в стек ответов
//		 * @param array $errors
//		 * @return void
//		 */
//		public static function pushErrors(array $errors): void {
//			self::push(self::TYPE_ERRORS, $errors);
//		}
//
//		/**
//		 * Отправляет стек ответов в формате JSON
//		 * @return void
//		 */
//		#[NoReturn] public static function sendJSON(): void {
////			if (DEBUGGER) self::$stack[] = ['type' => 'debugger', 'data' => \Base\Debugger::Get()];
//			self::sendJSONData(self::$stack);
//		}
//
//		/**
//		 * Отправляет сообщение об ошибке
//		 * @param string $notice - Текст сообщения
//		 * @return void
//		 */
//		#[NoReturn] public static function sendNoticeError(string $notice):void {
//			self::$stack = [];
//			self::pushNoticeError($notice);
//			self::sendJSON();
//		}
//
//		/**
//		 * Отправляет массив данных
//		 * @param array $data - Данные
//		 * @return void
//		 */
//		#[NoReturn] public static function sendData(array $data): void {
//			self::$stack = [];
//			self::pushData($data);
//			self::sendJSON();
//		}

	}