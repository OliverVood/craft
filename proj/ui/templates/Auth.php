<?php

	declare(strict_types=1);

	namespace Proj\UI\Templates;

	require_once DIR_PROJ_LAYOUTS . 'HeaderMainFooter.php';

	use Base\UI\Layout;
	use Base\UI\Template;
	use Proj\UI\Layouts;

	/**
	 * Шаблон аутентификации в админке
	 * @property Layouts\HeaderMainFooter $layout
	 */
	class Auth extends Template {
		public Layout $layout;

		public function __construct() {
			parent::__construct();

			$this->view = 'templates.adminAuth';

			$this->layout = new Layouts\HeaderMainFooter();

			$this->favicon(DIR_RELATIVE_PUBLIC_IMAGES . 'favicon.ico');

			$this->seo->setTitle('Craft App');

			$this->setJS();
			$this->setCSS();
		}

		/**
		 * Задаёт перечень JS файлов в шаблоне
		 * @return void
		 */
		private function setJS():  void {
			$this->js->add('https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
			$this->js->add('/public/js/base.js', app()->version());
		}

		/**
		 * Задаёт перечень CSS файлов в шаблоне
		 * @return void
		 */
		private function setCSS(): void {
			$this->css->add('/public/css/auth.css', app()->version());
		}

	}