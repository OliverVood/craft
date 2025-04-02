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

	route()->registration('groups::access', 'access.groups::access', Controllers::SOURCE_EDITORS);
	route()->registration('groups::select', 'groups::select', Controllers::SOURCE_EDITORS);
	route()->registration('groups::browse', 'groups::browse', Controllers::SOURCE_EDITORS);
	route()->registration('groups::create', 'groups::create', Controllers::SOURCE_EDITORS);
	route()->registration('groups::update', 'groups::update', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_access', 'access.groups::doAccess', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_create', 'groups::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_update', 'groups::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_delete', 'groups::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('users::access', 'access.users::access', Controllers::SOURCE_EDITORS);
	route()->registration('users::select', 'users::select', Controllers::SOURCE_EDITORS);
	route()->registration('users::browse', 'users::browse', Controllers::SOURCE_EDITORS);
	route()->registration('users::create', 'users::create', Controllers::SOURCE_EDITORS);
	route()->registration('users::update', 'users::update', Controllers::SOURCE_EDITORS);
	route()->registration('users::do_access', 'access.users::doAccess', Controllers::SOURCE_EDITORS);
	route()->registration('users::do_create', 'users::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('users::do_update', 'users::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('users::do_delete', 'users::doDelete', Controllers::SOURCE_EDITORS);