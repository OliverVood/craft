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
		const TYPE_SECTIONS = 'sections';
		const TYPE_HISTORY = 'history';
		const TYPE_DEBUGGER = 'debugger';
		const TYPE_NOTICES = 'notices';
		const TYPE_NOTICE_OK = 'ok';
		const TYPE_NOTICE_INFO = 'info';
		const TYPE_NOTICE_ERROR = 'error';

		private array $response = [];

		/**
		 * Код 200. Успех.
		 * @param array|null $data - Данные
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function ok(?array $data = null, string $notice = ''): void {
			if (!is_null($data)) $this->data($data);
			if ($notice) $this->noticeOk($notice);
			$this->send(200);
		}

		/**
		 * Код 201. Создано.
		 * @param array|null $data - Данные
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function created(?array $data = [], string $notice = ''): void {
			if (!is_null($data)) $this->data($data);
			if ($notice) $this->noticeOk($notice);
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
			if ($notice) $this->noticeError($notice);
			if ($data) $this->data($data);
			$this->send(400);
		}

		/**
		 * Код 401. Ошибка аутентификации.
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function unauthorized(string $notice = ''): void {
			if ($notice) $this->noticeError($notice);
			$this->send(401);
		}

		/**
		 * Код 403. Ошибка авторизации.
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function forbidden(string $notice = ''): void {
			if ($notice) $this->noticeError($notice);
			$this->send(403);
		}

		/**
		 * Код 404. Страница или контент не найден.
		 * @param string $notice - Оповещение
		 * @return void
		 */
		#[NoReturn] public function notFound(string $notice = ''): void {
			if ($notice) $this->noticeError($notice);
			$this->send(404);
		}

		/**
		 * Код 422. Запрос корректен с точки зрения синтаксиса, но его выполнение невозможно. Ошибка валидации.
		 * @param string $notice - Оповещение
		 * @param array $data - Данные
		 * @return void
		 */
		#[NoReturn] public function unprocessableEntity(string $notice = '', array $data = []): void {
			if ($notice) $this->noticeError($notice);
			if ($data) $this->data($data);
			$this->send(422);
		}

		/**
		 * Отправляет ответ в формате JSON
		 * @param int $code - Код
		 * @return void
		 */
		#[NoReturn] private function send(int $code): void {
			if (env('APP_DEBUGGER')) $this->debugger(debugger()->getLog());
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
			$this->push(self::TYPE_SECTIONS, ['name' => $section, 'html' => $html, 'empty' => $empty]);
		}

		/**
		 * Добавляет историю в стек ответов
		 * @param Internal $action - Действие
		 * @param array $data - Данные
		 * @return void
		 */
		public function history(Internal $action, array $data = []): void {
			if (get('no_history')->bool(false)) return;
			$this->set(self::TYPE_HISTORY, ['address' => $action->href($data), 'xhr' => $action->path($data)]);
		}

		/**
		 * Добавляет данные отладчика в ответ
		 * @param array $data - Данные
		 * @return void
		 */
		public function debugger(array $data): void {
			$this->set(self::TYPE_DEBUGGER, $data);
		}

		/**
		 * Добавляет оповещение об успехе
		 * @param string $notice - Сообщение
		 * @return void
		 */
		public function noticeOk(string $notice): void {
			$this->notice(self::TYPE_NOTICE_OK, $notice);
		}

		/**
		 * Добавляет информационное оповещение
		 * @param string $notice - Сообщение
		 * @return void
		 */
		public function noticeInfo(string $notice): void {
			$this->notice(self::TYPE_NOTICE_INFO, $notice);
		}

		/**
		 * Добавляет оповещение об ошибке
		 * @param string $notice - Сообщение
		 * @param array $data - Данные
		 * @return void
		 */
		public function noticeError(string $notice, array $data = []): void {
			$this->notice(self::TYPE_NOTICE_ERROR, $notice, $data);
		}

		/**
		 * Добавляет оповещение в ответ
		 * @param string $type - Тип
		 * @param string $text - Текст
		 * @param array $data - Данные
		 * @return void
		 */
		private function notice(string $type, string $text, array $data = []): void {
			$this->push(self::TYPE_NOTICES, ['type' => $type, 'text' => $text, 'data' => $data]);
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

	}