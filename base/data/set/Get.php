<?php

	namespace Base\Data\Set;

	class Get extends Data {
		public function __construct() {
			parent::__construct($_GET);
		}

	}