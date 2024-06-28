<?php

	namespace Proj\Actions\Admin;

	use Base\Link\Intenal;

	abstract class User {
		const NAME = 'user';

		public static Intenal $auth;
		public static Intenal $exit;

		public static function reg() {
			self::$auth			= new Intenal(self::NAME, 'auth', 'default', /* @lang JavaScript */ "Base.Common.Query.SubmitForm(this, () => location.reload()); return false;");
			self::$exit			= new Intenal(self::NAME, 'exit', 'default', /* @lang JavaScript */ "Base.Common.Query.Send('/users/exit', () => location.reload()); return false;");
		}
	}

	User::reg();