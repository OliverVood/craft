<?php

	namespace  Proj\Templates\Admin;

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
			self::$name = 'admin';
			self::$file = 'template.tpl';

			self::$layout = new Layout();

			self::$css = new CSS();
			self::$js = new JS();
			self::$seo = new SEO();

			self::$seo->setTitle('Craft App');

			self::setCSS();
		}

		private static function setCSS(): void {
			self::$css->add('/proj/templates/admin/css/main.min.css');
		}

	}