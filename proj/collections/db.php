<?php

	namespace Proj\Collections;

	use Base\Collection;

	interface DB extends Collection {
		const ID						= COLLECTION_DB_ID;
		const NAME						= 'db';
		const TITLE						= 'База данных';

		const CHECK						= 8;
		const MAKE						= 9;
		const STRUCTURE					= 10;
	}