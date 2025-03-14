<?php

	declare(strict_types=1);

	namespace Proj\UI\Templates\Admin;

	require_once DIR_PROJ_LAYOUTS . 'Admin.php';

	use Proj\UI\Layouts\Admin as Layout;

	/**
	 * Шаблон админки
	 */
	class Template extends \Base\UI\Template {

		public function __construct() {
			parent::__construct();

			$this->view = 'admin.templates.main';

			$this->layout = new Layout();

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
			$this->js->add('/base/ui/js/base.js', app()->version());
			$this->js->add('/proj/ui/templates/admin/js/db.js', app()->version());
		}

		/**
		 * Задаёт перечень CSS файлов в шаблоне
		 * @return void
		 */
		private function setCSS(): void {
			$this->css->add('/proj/ui/templates/admin/css/main.min.css');
		}

	}