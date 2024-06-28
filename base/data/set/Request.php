<?php

	namespace Base\Data\Set;

	class Request extends Data {
		public function __construct() {
			parent::__construct($_REQUEST);
		}

	}