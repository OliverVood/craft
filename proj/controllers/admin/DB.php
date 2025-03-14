<?php

	namespace Proj\Controllers\Admin;

	use Base\ControllerAccess;
	use Base\Data\Set\Input;
	use Base\Helper\Response;
	use Base\UI\View;
	use Proj\Access\Admin as Access;
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
			if (!$this->allow(Access\DB::ACCESS_DB_STRUCTURE)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

			/** @var \Proj\Models\DB $dbModel */ $dbModel = $this->model('db');

			$structure = $dbModel->structure();

			Response::pushHistory(Links\DB::$structure);
			Response::pushSection('content', View::get('admin.db.structure', compact('structure')));
			Response::SendJSON();
		}

		/**
		 * Проверяет структуру базы данных
		 * @controllerMethod
		 * @return void
		 */
		public function check(): void {
			if (!$this->allow(Access\DB::ACCESS_DB_CHECK)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

			/** @var \Proj\Models\DB $dbModel */ $dbModel = $this->model('db');

			$data = $dbModel->check();
			$action = Links\DB::$make->xhr();

			Response::pushHistory(Links\DB::$check);
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
			if (!$this->allow(Access\DB::ACCESS_DB_MAKE)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

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