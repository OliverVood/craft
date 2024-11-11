<?php

	namespace  Proj\Templates\Auth;

	use Base\Template\CSS;
	use Base\Template\JS;
	use Base\Template\SEO;

	/**
	 * Шаблон авторизации в админке
	 */
	class Template extends \Base\Template\Template {
		protected static string $name;
		protected static string $file;
		public static Layout $layout;

		public static CSS $css;
		public static JS $js;
		public static SEO $seo;

		/**
		 * Инициализация шаблона
		 * @return void
		 */
		public static function init(): void {
			self::$name = 'auth';
			self::$file = 'template.tpl';

			self::$layout = new Layout();

			self::$css = new CSS();
			self::$js = new JS();
			self::$seo = new SEO();

			self::$seo->setTitle('Craft App');

			self::setJS();
			self::setCSS();
		}

		/**
		 * Задаёт перечень JS файлов в шаблоне
		 * @return void
		 */
		private static function setJS():  void {
			self::$js->add('https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
			self::$js->add('/base/template/js/base.js', ASSEMBLY_VERSION);
		}

		/**
		 * Задаёт перечень CSS файлов в шаблоне
		 * @return void
		 */
		private static function setCSS(): void {
			self::$css->add('/proj/templates/auth/css/main.min.css', ASSEMBLY_VERSION);
		}

	}