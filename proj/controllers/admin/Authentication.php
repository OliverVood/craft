<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\Helper;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models\Users;
	use Proj\UI\Templates\Auth\Template as Template;

	/**
	 * Работа с Авторизацией
	 * @controller
	 */
	#[AllowDynamicProperties] class Authentication extends Controller {
		public function __construct() {
			parent::__construct(app()->features('authentication')->id());
		}

		/**
		 * Проверяет аутентификацию для HTML
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function isAuthHTML(): void {
			/** @var Users $users */ $users = model('users');

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
			/** @var Users $users */ $users = model('users');

			if ($users->isAuth()) return;

			Helper\Response::sendNoticeError(__('Пожалуйста, авторизуйтесь'));
		}

	}