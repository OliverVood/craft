<?php

	namespace Proj\Links\Admin;

	use Base\Link\Right;

	/**
	 * Ссылки сущности база данных
	 */
	abstract class DB {
		const NAME = 'db';

		public static Right $structure;
		public static Right $check;
		public static Right $make;

		public static function reg(): void {
			self::$structure	= new Right(self::NAME, 'structure', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress('/db/structure'); return false;");
			self::$check		= new Right(self::NAME, 'check', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress('/db/check'/*, Admin.General.Render.CheckDB*/); return false;");
			self::$make			= new Right(self::NAME, 'make', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress('/db/make'/*, Admin.General.Render.CheckDB*/); return false;");
		}

	}

	DB::reg();