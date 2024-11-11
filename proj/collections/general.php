<?php

	namespace Proj\Collections;

	use Base\Collection;

	interface General extends Collection {
		const ID						= COLLECTION_GENERAL_ID;
		const NAME						= 'general';
		const TITLE						= 'Основное';

		const ACCESS_SETTING			= 1;
	}