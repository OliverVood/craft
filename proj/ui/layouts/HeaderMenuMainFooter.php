<?php

	declare(strict_types=1);

	namespace Proj\UI\Layouts;

	use Base\UI\Layout;
	use Base\UI\Section;

	/**
	 * Макет header-menu-main-footer
	 */
	class HeaderMenuMainFooter extends Layout {
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