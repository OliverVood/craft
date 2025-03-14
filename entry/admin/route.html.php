<?php

	declare(strict_types=1);

	route()->registration('*::*', 'admin.authentication::isAuthHTML');

	route()->registration('*::*', 'admin.out::setHead');
	route()->registration('*::*', 'admin.out::setMenu');
	route()->registration('*::*', 'admin.out::setFooter');