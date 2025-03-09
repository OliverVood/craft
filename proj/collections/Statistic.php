<?php

	namespace Proj\Collections;

	use Base\Collection;
	use Proj\Consts\Collections;

	interface Statistic extends Collection {
		const ID						= Collections\STATISTIC['id'];
		const NAME						= Collections\STATISTIC['name'];
		const TITLE						= 'Статистика';

		const TABLES					= [
			'ip' => 'statistics_ip',
			'act' => 'statistics_act',
		];
	}