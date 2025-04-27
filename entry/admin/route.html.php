<?php

	declare(strict_types=1);

	route()->registration('/admin/:(all)', 'admin.authentication::isAuthHTML');

	route()->registration('/admin/:(all):[get]', 'admin.out::setHead');
	route()->registration('/admin/:(all):[get]', 'admin.out::setMenu');
	route()->registration('/admin/:(all):[get]', 'admin.out::setFooter');