<?php

	namespace Proj\Collections;

	use Base\Collection;

	interface Statistic extends Collection {
		const ID						= COLLECTION_STATISTIC_ID;
		const NAME						= 'statistic';
		const TITLE						= 'Статистика';

		const TABLES					= [
			'ip' => 'statistics_ip',
			'act' => 'statistics_act',
		];
	}