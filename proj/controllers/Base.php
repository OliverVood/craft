<?php

	namespace Proj\Controllers;

	use Base\Controller;
	use Proj\Templates\Site\Template;

	/**
	 * Базовый контроллер
	 */
	class Base extends Controller {
		/**
		 * Выводит подвал
		 * @return void
		 */
		public function Footer(): void {
			Template::$layout->footer->push('footer');
		}

	}