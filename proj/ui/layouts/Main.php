<?php

	declare(strict_types=1);

	namespace Proj\UI\Layouts;

	use Base\UI\Layout;
	use Base\UI\Section;

	/**
	 * Макет с одной секцией main
	 */
	class Main extends Layout {
		public Section $main;

		public function __construct() {
			$this->main = new Section();
		}

	}