<?php

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\Data\Set\Input;
	use Base\Helper;
	use Base\Model;
	use Proj\Collections;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Работа с пользователями
	 * @controller
	 * @property \Proj\Models\User $user
	 */
	#[AllowDynamicProperties] class User extends Controller implements Collections\User {
		public function __construct() {
			parent::__construct(self::ID);
		}

		/**
		 * Аутентификация пользователя
		 * @controllerMethod
		 * @param Input $input - пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function auth(Input $input): void {
			$this->user = Model::get('user');

			if ($this->user->isAuth()) Helper\Response::sendNoticeError(__('Вы уже вошли систему'));

			$login = $input->defined('login')->string('');
			$password = $input->defined('password')->string('');

			if (!$this->user->auth($login, $password)) Helper\Response::sendNoticeError(__('Ошибка доступа'));

			Helper\Response::sendData([]);
		}

		/**
		 * Выход из системы
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function exit(): void {
			$this->user = Model::get('user');

			$this->user->logout();

			Helper\Response::sendData([]);
		}

	}