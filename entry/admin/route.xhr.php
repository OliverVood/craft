<?php

	declare(strict_types=1);

	use Base\Controllers;

	route()->registration('users::auth', 'admin.users::auth');
	route()->registration('*::*', 'admin.authentication::isAuthXHR');
	route()->registration('users::exit', 'admin.users::exit');

	route()->registration('main::index', 'admin.out::home');

	route()->registration('dbs::structure', 'admin.dbs::structure');
	route()->registration('dbs::check', 'admin.dbs::check');
	route()->registration('dbs::make', 'admin.dbs::make');

	route()->registration("statistics_ips::select", "statistics.ips::select", Controllers::SOURCE_EDITORS);
//	Base\Route::set('statistic_ip::*', 'statistic.ip', Base\Route::SOURCE_EDITORS);
//	Base\Route::set('statistic_action::*', 'statistic.action', Base\Route::SOURCE_EDITORS);
//	Base\Route::set('group::*', 'user.group', Base\Route::SOURCE_EDITORS);
//	Base\Route::set('user::*', 'user.user', Base\Route::SOURCE_EDITORS);