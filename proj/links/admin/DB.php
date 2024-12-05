<?php

	namespace Proj\Links\Admin;

	use Base\Link\Right;
	use Proj\Access\Admin as Access;

	/**
	 * Ссылки сущности база данных
	 */
	abstract class DB {
		const NAME = 'db';

		public static Right $structure;
		public static Right $check;
		public static Right $make;

		/**
		 * Регистрирует ссылки
		 * @return void
		 */
		public static function reg(): void {
			self::$structure	= new Right(COLLECTION_DB_ID, Access\DB::ACCESS_DB_STRUCTURE, self::NAME, 'structure', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress('/db/structure'); return false;");
			self::$check		= new Right(COLLECTION_DB_ID, Access\DB::ACCESS_DB_CHECK, self::NAME, 'check', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress('/db/check'/*, Admin.General.Render.CheckDB*/); return false;");
			self::$make			= new Right(COLLECTION_DB_ID, Access\DB::ACCESS_DB_MAKE, self::NAME, 'make', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress('/db/make'/*, Admin.General.Render.CheckDB*/); return false;");
		}

	}

	DB::reg();