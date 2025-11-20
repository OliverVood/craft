<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\Controller;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Editors;

	/**
	 * Работа с шаблоном
	 * @controller
	 * @property Users $users
	 */
	class Out extends Controller {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * Главная страница
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function home(): void {
			response()->history(linkInternal('home'));
			response()->section('content', view('admin.out.home'));
			response()->ok();
		}

		/**
		 * Страница не найдена
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function error404(): void {
			response()->notFound(__('Страница не найдена'));
		}

	}