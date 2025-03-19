<?php

	declare(strict_types=1);

	namespace Base\Data;

	/**
	 * Хранение пользовательских данные из суперглобального массива $_REQUEST
	 */
	class Request extends Base {
		public function __construct() {
			parent::__construct($_REQUEST);
		}

	}