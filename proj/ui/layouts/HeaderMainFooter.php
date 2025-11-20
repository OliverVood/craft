<?php

	declare(strict_types=1);

	namespace Proj\UI\Layouts;

	use Base\UI\Layout;
	use Base\UI\Section;

	/**
	 * Макет header-main-footer
	 */
	class HeaderMainFooter extends Layout {
		public Section $header;
		public Section $main;
		public Section $footer;

		public function __construct() {
			$this->header = new Section();
			$this->main = new Section();
			$this->footer = new Section();
		}

	}