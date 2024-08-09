<?php

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\Helper;
	use Base\Model;
	use Base\Template\Template as BaseTemplate;
	use Base\View;
	use JetBrains\PhpStorm\NoReturn;
	use proj\models\User;
	use Proj\Templates\Auth\Template as AuthTemplate;

	/**
	 * Контроллер авторизации
	 * @property User $user
	 */
	#[AllowDynamicProperties] class Authorization extends Controller {
		/**
		 * Проверяет аутентификацию для HTML
		 * @return void
		 */
		#[NoReturn] public function isAuthHTML(): void {
			$this->user = Model::get('user');

			if ($this->user->isAuth()) return;

			BaseTemplate::load('auth');
			AuthTemplate::init();

			AuthTemplate::$layout->header->push(__('Вход в систему'));
			AuthTemplate::$layout->main->push(View::get('admin.user.form_authorization'));
			AuthTemplate::$layout->footer->push(__('Разработан в © Craft'));

			AuthTemplate::browse();

			die;
		}

		/**
		 * Проверяет аутентификацию для XHR
		 * @return void
		 */
		public function isAuthXHR(): void {
			$this->user = Model::get('user');

			if ($this->user->isAuth()) return;

			Helper\Response::sendNoticeError(__('Пожалуйста, авторизуйтесь'));
		}

	}