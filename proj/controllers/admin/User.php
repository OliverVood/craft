<?php

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\Data\Set\Input;
	use Base\Helper;
	use Base\Model;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Контроллер пользователей
	 * @property \Proj\Models\User $user
	 */
	#[AllowDynamicProperties] class User extends Controller {

		/**
		 * Аутентификация пользователя
		 * @param Input $input - пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function auth(Input $input) {

			$this->user = Model::get('user');

			if ($this->user->isAuth()) Helper\Response::sendNoticeError(__('Вы уже вошли систему'));

			$login = $input->defined('login')->string('');
			$password = $input->defined('password')->string('');

			if (!$this->user->auth($login, $password)) {
//				Response::PushNoticeError('Ошибка доступа');
//				Response::SendJSON();
			}die('asd');

//			Response::PushData([]);
//			Response::SendJSON();
		}
	}