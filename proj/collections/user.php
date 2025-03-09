<?php

	namespace Proj\Collections;

	use Base\Collection;

	interface User extends Collection {
		const TABLES					= [
			'clients' => 'clients',
		];
	}