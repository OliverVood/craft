<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\Controller;
	use Base\Data\Set;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models;

	/**
	 * Работа с пользователями
	 * @controller
	 */
	class Users extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Аутентификация пользователя
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function auth(Set $data): void {
			/** @var Models\Users $users */ $users = model('users');

			if ($users->isAuth()) response()->notFound(__('Вы уже вошли систему'));

			$errors = [];
			$data = validation($data->defined()->all(), [
				'login' => ['string', 'required'],
				'password' => ['string', 'required', 'encryption'],
			], [], $errors);

			if ($errors) response()->unprocessableEntity('Ошибка валидации', $errors);

			if (!$users->auth($data['login'], $data['password'])) response()->unauthorized(__('Не правильный логин или пароль'));

			response()->ok();
		}

		/**
		 * Выход из системы
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function exit(): void {
			/** @var Models\Users $users */ $users = model('users');

			$users->logout();

			response()->ok();
		}

	}