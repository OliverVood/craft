<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\Controller;
	use Proj\Models;
	use Proj\UI\Templates\Auth\Template as Template;

	/**
	 * Работа с Авторизацией
	 * @controller
	 */
	class Authentication extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Проверяет аутентификацию для HTML
		 * @controllerMethod
		 * @return void
		 */
		public function isAuthHTML(): void {
			/** @var Models\Users $users */ $users = model('users');

			if ($users->isAuth()) return;

			/** @var Template $template */ $template = template('auth.template');

			$template->layout->header->push(__('Вход в систему'));
			$template->layout->main->push(view('admin.users.form_authorization'));
			$template->layout->footer->push(__('Разработан в © Craft'));

			$template->browse(true);
		}

		/**
		 * Проверяет аутентификацию для XHR
		 * @controllerMethod
		 * @return void
		 */
		public function isAuthXHR(): void {
			/** @var Models\Users $users */ $users = model('users');

			if ($users->isAuth()) return;

			response()->unauthorized(__('Пожалуйста, авторизуйтесь'));
		}

	}