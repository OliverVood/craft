<?php

	namespace base\data\set;

	/**
	 * Хранение пользовательских данных из объединённых суперглобальных массивов $_POST и $_GET
	 */
	class Defined extends Base {
		public function __construct() {
			parent::__construct(array_merge($_GET, $_POST));
		}

	}