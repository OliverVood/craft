<?php

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\Model;
	use Base\Template\Template as BaseTemplate;
	use Base\View;
	use JetBrains\PhpStorm\NoReturn;
	use proj\models\User;
	use Proj\Templates\Admin\Template as AdminTemplate;
	use Proj\Templates\Auth\Template as AuthTemplate;

	/**
	 * @property User $user
	 */
	#[AllowDynamicProperties] class Base extends Controller {
		#[NoReturn] public function isAuth(): void {
			$this->user = Model::get('user');
			if ($this->user->isAuth()) return;

			BaseTemplate::load('auth');
			AuthTemplate::init();

			AuthTemplate::$layout->header->Push('Вход в систему');
			AuthTemplate::$layout->main->push(View::get('admin.user.form_authorization'));
			AuthTemplate::$layout->footer->Push('Разработан в © Craft');

			AuthTemplate::browse();

			die;
		}

		public function Footer(): void {
			AdminTemplate::$layout->footer->push('footer admin');
		}

	}