<?php

	declare(strict_types=1);

	namespace Base\Link;

	/**
	 * Класс внешних ссылок
	 */
	class External extends Fundamental {
		protected string $address;
		protected string $click;

		public function __construct(string $address = '', string $click = '') {
			parent::__construct($address, $click);
		}

	}