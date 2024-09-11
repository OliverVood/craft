<?php

	namespace Proj\Controllers\Admin;

	use Base\ControllerAccess;
	use Base\Helper\Response;
	use Base\View;
	use Proj\Collections;
	use Proj\Links\Admin as Links;

	/**
	 * Контроллер работы с базой данных
	 * @controller
	 */
	class DB extends ControllerAccess implements Collections\DB {

		public function __construct() {
			parent::__construct(self::ID);
		}

		/**
		 * Возвращает структуру базы данных
		 * @return void
		 * @controllerMethod
		 */
		public function structure(): void {
			if (!$this->allow(self::STRUCTURE)) Response::sendNoticeError(__(self::TEXT_ERROR_ACCESS));

			/** @var \Proj\Models\DB $dbModel */ $dbModel = $this->model('db');

			$structure = $dbModel->structure();

			Response::PushHistory(Links\DB::$structure);
			Response::pushSection('content', View::get('admin.db.structure', compact('structure')));
			Response::SendJSON();
		}

	}