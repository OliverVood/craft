<?php

	declare(strict_types=1);

	namespace Proj\Middlewares\Admin;

	use Base\Middleware;
	use Proj\Models;
	use Proj\UI\Templates\Auth\Template as Template;

	/**
	 * Аутентификация пользователя по HTML
	 */
	class AuthenticationHTML extends Middleware {

		/**
		 * Before
		 * @return void
		 */
		public function inlet(): void {
			/** @var Models\Users $users */ $users = model('users');

			if ($users->isAuth()) return;

			/** @var Template $template */ $template = template('auth.template');

			$template->layout->header->push(__('Вход в систему'));
			$template->layout->main->push(view('admin.users.form_authorization'));
			$template->layout->footer->push(__('Разработан в © Craft'));

			$template->browse(true);
		}

		/**
		 * After
		 * @return void
		 */
		public function outlet(): void {  }

	}
