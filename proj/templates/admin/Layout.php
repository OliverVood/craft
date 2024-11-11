<?php

	namespace Proj\Templates\Admin;

	use Base\Template\Section;

	/**
	 * Макет админки
	 */
	class Layout extends \Base\Template\Layout {
		public Section $header;
		public Section $menu;
		public Section $content;
		public Section $footer;

		public function __construct() {
			$this->header = new Section();
			$this->menu = new Section();
			$this->content = new Section();
			$this->footer = new Section();
		}

	}