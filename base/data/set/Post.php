<?php

	namespace Base\Data\Set;

	/**
	 * Хранение пользовательских данные из суперглобального массива $_POST
	 */
	class Post extends Data {
		public function __construct() {
			parent::__construct($_POST);
		}

	}