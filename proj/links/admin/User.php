<?php

	namespace Proj\Links\Admin;

	use Base\Link\Intenal;

	/**
	 * Ссылки сущности пользователь
	 */
	abstract class User {
		const NAME = 'user';

		public static Intenal $auth;
		public static Intenal $exit;

		/**
		 * Регистрирует ссылки
		 * @return void
		 */
		public static function reg(): void {
			self::$auth			= new Intenal(self::NAME, 'auth', 'default', /* @lang JavaScript */ "Base.Query.submitForm(this, () => location.reload()); return false;");
			self::$exit			= new Intenal(self::NAME, 'exit', 'default', /* @lang JavaScript */ "Base.Query.send('/users/exit', () => location.reload()); return false;");
		}
	}

	User::reg();