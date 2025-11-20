<?php

	declare(strict_types=1);

	namespace Proj\UI\Templates;

	require_once DIR_PROJ_LAYOUTS . 'HeaderMenuMainFooter.php';

	use Base\UI\Layout;
	use Base\UI\Template;
	use Proj\UI\Layouts;

	/**
	 * Шаблон админки
	 * @property Layouts\HeaderMenuMainFooter $layout
	 */
	class Admin extends Template {
		public Layout $layout;

		public function __construct() {
			parent::__construct();

			$this->view = 'templates.admin';

			$this->layout = new Layouts\HeaderMenuMainFooter();

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
			$this->js->add('/public/js/admin.js', app()->version());
			$this->js->add('/public/js/db.js', app()->version());
		}

		/**
		 * Задаёт перечень CSS файлов в шаблоне
		 * @return void
		 */
		private function setCSS(): void {
			$this->css->add('/public/css/admin.css');
		}

	}