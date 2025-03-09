<?php

	namespace Base\Data\Set;

	/**
	 * Хранение пользовательские данные из суперглобального массива $_GET
	 */
	class Get extends Base {
		public function __construct() {
			parent::__construct($_GET);
		}

	}