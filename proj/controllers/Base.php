<?php

	namespace Proj\Controllers;

	use Base\Controller;
	use proj\ui\templates\site\Template;

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