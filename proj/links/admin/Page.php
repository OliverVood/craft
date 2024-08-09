<?php

	namespace Proj\Links\Admin;

	use Base\Link\External;
	use Base\Link\Internal;

	/**
	 * Ссылки сущности страница
	 */
	abstract class Page {
		const NAME = 'page';

		public static Internal $home;

		public static External $site;

		/**
		 * Регистрирует ссылки
		 * @return void
		 */
		public static function reg(): void {
			self::$home			= new Internal('', '', 'default', /** @lang JavaScript */ "Base.Query.sendToAddress(''); return false;");

			self::$site			= new External('/');
		}

	}

	Page::reg();