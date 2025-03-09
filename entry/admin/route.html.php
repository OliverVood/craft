<?php

	declare(strict_types=1);

	route()->registration('*::*', 'admin.authorization::isAuthHTML');

	route()->registration('*::*', 'admin.out::setHead');
	route()->registration('*::*', 'admin.out::setMenu');
	route()->registration('*::*', 'admin.out::setFooter');