<?php

	declare(strict_types=1);

	namespace Base\Data;

	/**
	 * Хранение пользовательских данные из суперглобального массива $_POST
	 */
	class Post extends Base {
		public function __construct() {
			parent::__construct($_POST);
		}

	}