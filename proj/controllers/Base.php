<?php

	namespace Proj\Controllers;

	use Base\Controller;
	use \Proj\Templates\Site\Template;

	class Base extends Controller {
		public function Footer(): void {
			Template::$layout->footer->push('footer');
		}

	}