<?php

	namespace Proj\Access\Admin;

	use Base\Access;
	use Proj\Collections;

	abstract class DB implements Collections\DB {
		const ACCESS_DB_CHECK			= 1;
		const ACCESS_DB_MAKE			= 2;
		const ACCESS_DB_STRUCTURE		= 3;

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		public static function reg(): void {
			Access::addCollection(self::ID, self::NAME, __(self::TITLE));

			Access::addRight(self::ID, self::ACCESS_DB_CHECK, 'check', __('Проверить БД'));
			Access::addRight(self::ID, self::ACCESS_DB_MAKE, 'make', __('Исправить БД'));
			Access::addRight(self::ID, self::ACCESS_DB_STRUCTURE, 'structure', __('Структура БД'));
		}

	}

	DB::reg();