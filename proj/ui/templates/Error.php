<?php

	declare(strict_types=1);

	namespace Proj\UI\Templates;

	require_once DIR_PROJ_LAYOUTS . 'Main.php';

	use Base\UI\Layout;
	use Base\UI\Template;
	use Proj\UI\Layouts;

	/**
	 * Шаблон ошибки приложения
	 * @property Layouts\Main $layout
	 */
	class Error extends Template {
		public Layout $layout;

		public function __construct() {
			parent::__construct();

			$this->view = 'templates.error';

			$this->layout = new Layouts\Main();

			$this->favicon(DIR_RELATIVE_PUBLIC_IMAGES . 'favicon.ico');

			$this->seo->setTitle('Craft App | Errors');
		}

	}