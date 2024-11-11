<?php

	namespace Proj\Collections;

	use Base\Collection;

	interface Authorization extends Collection {
		const ID						= COLLECTION_AUTHORIZATION_ID;
		const NAME						= 'authorization';
		const TITLE						= 'Авторизация';
	}