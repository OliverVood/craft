<?php

	namespace base\data\set;

	class Defined extends Data {
		public function __construct() {
			parent::__construct(array_merge($_GET, $_POST));
		}

	}