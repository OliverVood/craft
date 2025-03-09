<?php

	namespace Proj\Collections;

	use Base\Collection;
	use Proj\Consts\Collections;

	interface General extends Collection {
		const ID						= Collections\GENERAL['id'];
		const NAME						= Collections\GENERAL['name'];
		const TITLE						= 'Основное';
	}