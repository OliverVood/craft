<?php

	namespace proj\ui\templates\site;

	use Base\Template\Section;

	/**
	 * Макет сайта
	 */
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