<?php

	namespace Proj\Controllers\Admin;

	use Base\ControllerAccess;
	use Base\Data\Set\Input;
	use Base\Helper\Response;
	use Base\View;
	use Proj\Collections;
	use Proj\Links\Admin as Links;

	/**
	 * Работа с базой данных
	 * @controller
	 */
	class DB extends ControllerAccess implements Collections\DB {
		public function __construct() {
			parent::__construct(self::ID);
		}

		/**
		 * Возвращает структуру базы данных
		 * @controllerMethod
		 * @return void
		 */
		public function structure(): void {
			if (!$this->allow(self::STRUCTURE)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

			/** @var \Proj\Models\DB $dbModel */ $dbModel = $this->model('db');

			$structure = $dbModel->structure();

			Response::PushHistory(Links\DB::$structure);
			Response::pushSection('content', View::get('admin.db.structure', compact('structure')));
			Response::SendJSON();
		}

		/**
		 * Проверяет структуру базы данных
		 * @controllerMethod
		 * @return void
		 */
		public function check(): void {
			if (!$this->allow(self::CHECK)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

			/** @var \Proj\Models\DB $dbModel */ $dbModel = $this->model('db');

			$data = $dbModel->check();
			$action = Links\DB::$make->xhr();

			Response::PushHistory(Links\DB::$check);
			Response::pushSection('content', View::get('admin.db.check', compact('data', 'action')));
			Response::SendJSON();
		}

		/**
		 * Исправляет структуру базы данных
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function make(Input $input): void {
			if (!$this->allow(self::MAKE)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

			/** @var \Proj\Models\DB $dbModel */ $dbModel = $this->model('db');

			$data = $input->assoc('tables')->data([]);

			if (!$dbModel->make($data)) Response::sendNoticeError(__('Ошибка выполнения'));

			$data = $dbModel->check();
			$action = Links\DB::$make->xhr();

			Response::pushNoticeError(__('База данных успешно обновлена'));
			Response::pushData(compact('data', 'action'));
			Response::SendJSON();
		}

	}