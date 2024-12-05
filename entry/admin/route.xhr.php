<?php

	Base\Route::set('user::auth', 'admin.user::auth');

	Base\Route::set('*::*', 'admin.authorization::isAuthXHR');

	Base\Route::set('main::index', 'admin.out::home');
	Base\Route::set('db::structure', 'admin.db::structure');
	Base\Route::set('db::check', 'admin.db::check');
	Base\Route::set('db::make', 'admin.db::make');
	Base\Route::set('user::exit', 'admin.user::exit');

	Base\Route::set('statistic_ip::*', 'statistic.ip', Base\Route::SOURCE_EDITORS);
	Base\Route::set('statistic_action::*', 'statistic.action', Base\Route::SOURCE_EDITORS);