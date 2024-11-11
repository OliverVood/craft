<?php

	namespace Proj\Collections;

	use Base\Collection;

	interface User extends Collection {
		const ID						= COLLECTION_USER_ID;
		const NAME						= 'user';
		const TITLE						= 'Пользователи';

		const TABLES					= [
			'clients' => 'clients',
		];
	}