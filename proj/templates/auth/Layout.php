<?php

	namespace Proj\Templates\Auth;

	use Base\Template\Section;

	class Layout extends \Base\Template\Layout {
		public Section $header;
		public Section $main;
		public Section $footer;

		public function __construct() {
			$this->header = new Section();
			$this->main = new Section();
			$this->footer = new Section();
		}

	}