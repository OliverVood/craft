<?php

	namespace Base\Data\Set;

	class Post extends Data {
		public function __construct() {
			parent::__construct($_POST);
		}

	}