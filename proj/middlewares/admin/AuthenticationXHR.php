<?php

	declare(strict_types=1);

	namespace Proj\Middlewares\Admin;

	use Base\Middleware;
	use Proj\Models;

	/**
	 * Аутентификация пользователя по XHR
	 */
	class AuthenticationXHR extends Middleware {

		/**
		 * Before
		 * @return void
		 */
		public function inlet(): void {
			/** @var Models\Users $users */ $users = model('users');

			if ($users->isAuth()) return;

			response()->unauthorized(__('Пожалуйста, авторизуйтесь'));
		}

		/**
		 * After
		 * @return void
		 */
		public function outlet(): void {  }

	}
