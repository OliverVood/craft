<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;

	/**
	 * Отвечает за обработку запросов к донатам
	 * @controller
	 */
	class Donations extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Возвращает HTML для формы донатов
		 * @controllerMethod
		 * @return void
		 */
		public function index(): void {
			response()->ok(['html' =>view('site.donations.index')]);
		}

	}