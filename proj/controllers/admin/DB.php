<?php

	namespace Proj\Controllers\Admin;

	use Base\Controller;
	use Base\Helper\Response;
	use Base\View;
	use Proj\Links\Admin as Links;

	/**
	 * Контроллер работы с базой данных
	 */
	class DB extends Controller {
		public function structure(): void {
			Response::PushHistory(Links\DB::$structure);
			Response::pushSection('content', View::get('admin.db.structure'));
			Response::SendJSON();
		}

	}