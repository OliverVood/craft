<?php

	namespace Proj\Access\Admin;

	use Base\Access;
	use Proj\Collections;

	abstract class General implements Collections\General {
		const ACCESS_SETTING			= 1;

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		public static function reg(): void {
			Access::addCollection(self::ID, self::NAME, __(self::TITLE));

			Access::addRight(self::ID, self::ACCESS_SETTING, 'setting', __('Назначение прав'));
		}

	}

	General::reg();