<?php

	namespace  Proj\Templates\Site;

	use Base\Template\CSS;
	use Base\Template\JS;
	use Base\Template\SEO;

	/**
	 * Шаблон сайта
	 */
	class Template extends \Base\Template\Template {
		protected static string $name;
		protected static string $file;
		public static Layout $layout;

		public static CSS $css;
		public static JS $js;
		public static SEO $seo;

		/**
		 * Инициализирует шаблон
		 * @return void
		 */
		public static function init(): void {
			self::$name = 'site';
			self::$file = 'template.tpl';

			self::$layout = new Layout();

			self::$css = new CSS();
			self::$js = new JS();
			self::$seo = new SEO();

			self::setCSS();
		}

		/**
		 * Задаёт перечень CSS файлов в шаблоне
		 * @return void
		 */
		private static function setCSS(): void {
			self::$css->add('/proj/templates/site/css/main.min.css');
		}

	}