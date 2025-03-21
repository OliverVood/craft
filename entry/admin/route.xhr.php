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

	route()->registration('statistics_ips::select', 'statistics.ips::select', Controllers::SOURCE_EDITORS);
	route()->registration('statistics_actions::select', 'statistics.actions::select', Controllers::SOURCE_EDITORS);

	route()->registration('groups::select', 'groups::select', Controllers::SOURCE_EDITORS);
//	BaseRoute::set("{$this->name}::browse", "{$this->pathController}::browse", Controllers::SOURCE_EDITORS);
	route()->registration('groups::create', 'groups::create', Controllers::SOURCE_EDITORS);
//	BaseRoute::set("{$this->name}::update", "{$this->pathController}::update", Controllers::SOURCE_EDITORS);
//	BaseRoute::set("{$this->name}::delete", "{$this->pathController}::delete", Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_create', 'groups::doCreate', Controllers::SOURCE_EDITORS);
//	BaseRoute::set("{$this->name}::do_update", "{$this->pathController}::doUpdate", Controllers::SOURCE_EDITORS);
//	BaseRoute::set("{$this->name}::do_delete", "{$this->pathController}::doDelete", Controllers::SOURCE_EDITORS);

//	Base\Route::set('user::*', 'user.user', Base\Route::SOURCE_EDITORS);