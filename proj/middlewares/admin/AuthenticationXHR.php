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
		 * @return bool
		 */
		public function inlet(): bool {
			/** @var Models\Users $users */ $users = model('users');

			if ($users->isAuth()) return true;

			response()->unauthorized(__('Пожалуйста, авторизуйтесь'));

			return false;
		}

		/**
		 * After
		 * @return bool
		 */
		public function outlet(): bool {
			return true;
		}

	}
