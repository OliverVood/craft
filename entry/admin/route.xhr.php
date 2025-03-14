<?php

	declare(strict_types=1);

	route()->registration('users::auth', 'admin.users::auth');
	route()->registration('*::*', 'admin.authentication::isAuthXHR');
	route()->registration('users::exit', 'admin.users::exit');

	route()->registration('main::index', 'admin.out::home');
//	Base\Route::set('db::structure', 'admin.db::structure');
//	Base\Route::set('db::check', 'admin.db::check');
//	Base\Route::set('db::make', 'admin.db::make');
//
//	Base\Route::set('statistic_ip::*', 'statistic.ip', Base\Route::SOURCE_EDITORS);
//	Base\Route::set('statistic_action::*', 'statistic.action', Base\Route::SOURCE_EDITORS);
//	Base\Route::set('group::*', 'user.group', Base\Route::SOURCE_EDITORS);
//	Base\Route::set('user::*', 'user.user', Base\Route::SOURCE_EDITORS);