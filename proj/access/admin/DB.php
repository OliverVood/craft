<?php

	namespace Proj\Access\Admin;

	use Base\Access;
	use Proj\Collections\General;

	abstract class DB implements General {

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		public static function reg(): void {
			Access::addCollection(self::ID, self::NAME, __('Основное'));

			Access::AddRight(self::ID, self::ACCESS_SETTING, 'setting', __('Назначение прав'));
			Access::AddRight(self::ID, self::ACCESS_DB_CHECK, 'check', __('Проверить БД'));
			Access::AddRight(self::ID, self::ACCESS_DB_MAKE, 'make', __('Исправить БД'));
			Access::AddRight(self::ID, self::ACCESS_DB_STRUCTURE, 'structure', __('Структура БД'));
		}

	}

	DB::reg();