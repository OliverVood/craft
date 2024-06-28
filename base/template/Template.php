<?php

	namespace Base\Template;

	abstract class Template {
		use Buffer;

		protected static string $name;
		protected static string $file = 'template.tpl';

		public static CSS $css;
		public static JS $js;
		public static SEO $seo;

		public static function load(string $name): void {
			require_once DIR_PROJ_TEMPLATES . $name . '/layout.php';
			require_once DIR_PROJ_TEMPLATES . $name . '/template.php';
		}

		public static function browse(): void {
			self::start();
			require_once DIR_PROJ_TEMPLATES . static::$name . '/template.tpl';
			echo self::read();
		}

		public static function browseHead(): void {
			static::$js->browse();
			static::$css->browse();
			static::$seo->browse();
		}

	}