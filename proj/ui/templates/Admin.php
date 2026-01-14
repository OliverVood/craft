<?php

	declare(strict_types=1);

	namespace Proj\UI\Templates;

	require_once DIR_PROJ_LAYOUTS . 'HeaderManagerMenuMainFooter.php';

	use Base\UI\Layout;
	use Base\UI\Template;
	use Proj\UI\Layouts;

	/**
	 * Шаблон админки
	 * @property Layouts\HeaderManagerMenuMainFooter $layout
	 */
	class Admin extends Template {
		public Layout $layout;

		public function __construct() {
			parent::__construct();

			$this->view = 'templates.admin';

			$this->layout = new Layouts\HeaderManagerMenuMainFooter();

			$this->favicon(DIR_RELATIVE_IMAGES . 'craft/favicon.ico');

			$this->seo->setTitle('Craft App');

			$this->setJS();
			$this->setCSS();
		}

		/**
		 * Задаёт перечень JS файлов в шаблоне
		 * @return void
		 */
		private function setJS():  void {
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