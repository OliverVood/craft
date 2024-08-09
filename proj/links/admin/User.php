<?php

	namespace Proj\Links\Admin;

	use Base\Link\Internal;

	/**
	 * Ссылки сущности пользователь
	 */
	abstract class User {
		const NAME = 'user';

		public static Internal $auth;
		public static Internal $exit;

		/**
		 * Регистрирует ссылки
		 * @return void
		 */
		public static function reg(): void {
			self::$auth			= new Internal(self::NAME, 'auth', 'default', /* @lang JavaScript */ "Base.Query.submitForm(this, () => location.reload()); return false;");
			self::$exit			= new Internal(self::NAME, 'exit', 'default', /* @lang JavaScript */ "Base.Query.sendToAddress('/user/exit', () => location.reload()); return false;");
		}

	}

	User::reg();