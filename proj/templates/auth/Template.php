<?php

	namespace  Proj\Templates\Auth;

	use Base\Template\CSS;
	use Base\Template\JS;
	use Base\Template\SEO;

	class Template extends \Base\Template\Template {
		protected static string $name;
		protected static string $file;
		public static Layout $layout;

		public static CSS $css;
		public static JS $js;
		public static SEO $seo;

		public static function init(): void {
			self::$name = 'auth';
			self::$file = 'template.tpl';

			self::$layout = new Layout();

			self::$css = new CSS();
			self::$js = new JS();
			self::$seo = new SEO();

			self::$seo->setTitle('Craft App');

			self::setCSS();
		}

		private static function setCSS(): void {
			self::$css->add('/proj/templates/auth/css/main.min.css');
		}

	}