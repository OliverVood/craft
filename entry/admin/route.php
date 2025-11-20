<?php

	declare(strict_types=1);

	use Base\Controllers;

	route()->group('/admin', [
		route()->post('/xhr/users/auth', 'admin.users::auth')
			->middleware('clients')
			->middleware('statistics'),

		route()->group('/xhr', [
			route()->get('/users/exit', 'admin.users::exit'),

			route()->get('/', 'admin.out::home'),

			route()->group('/dbs', [
				route()->get('/structure', 'admin.dbs::structure'),
				route()->get('/check', 'admin.dbs::check'),
				route()->patch('/make', 'admin.dbs::make'),
			]),

			route()->group('/statistics', [
				route()->get('/ips', 'statistics.ips::select', Controllers::SOURCE_EDITORS),
				route()->get('/actions', 'statistics.actions::select', Controllers::SOURCE_EDITORS),
			]),

			route()->group('/groups', [
				route()->get('/:(num)/access', 'access.groups::access', Controllers::SOURCE_EDITORS),
				route()->get('', 'groups::select', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)', 'groups::browse', Controllers::SOURCE_EDITORS),
				route()->get('/create', 'groups::create', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)/update', 'groups::update', Controllers::SOURCE_EDITORS),
				route()->put('/:(num)/access', 'access.groups::doAccess', Controllers::SOURCE_EDITORS),
				route()->post('', 'groups::doCreate', Controllers::SOURCE_EDITORS),
				route()->patch('/:(num)', 'groups::doUpdate', Controllers::SOURCE_EDITORS),
				route()->delete('/:(num)', 'groups::doDelete', Controllers::SOURCE_EDITORS),
			]),

			route()->group('/users', [
				route()->get('/:(num)/access', 'access.users::access', Controllers::SOURCE_EDITORS),
				route()->get('', 'users::select', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)', 'users::browse', Controllers::SOURCE_EDITORS),
				route()->get('/create', 'users::create', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)/update', 'users::update', Controllers::SOURCE_EDITORS),
				route()->put('/:(num)/access', 'access.users::doAccess', Controllers::SOURCE_EDITORS),
				route()->post('', 'users::doCreate', Controllers::SOURCE_EDITORS),
				route()->patch('/:(num)', 'users::doUpdate', Controllers::SOURCE_EDITORS),
				route()->delete('/:(num)', 'users::doDelete', Controllers::SOURCE_EDITORS),
			]),

			route()->group('/craft', [
				route()->get('', 'admin.craft::index'),
				route()->get('/help', 'admin.craft::help'),
				route()->get('/:(str)/create', 'admin.craft::create'),
				route()->post('/:(str)/:(str)', 'admin.craft::run'),
			]),

			route()->group('/news', [
				route()->get('', 'site.news::select', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)', 'site.news::browse', Controllers::SOURCE_EDITORS),
				route()->get('/create', 'site.news::create', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)/update', 'site.news::update', Controllers::SOURCE_EDITORS),
				route()->post('', 'site.news::doCreate', Controllers::SOURCE_EDITORS),
				route()->patch('/:(num)', 'site.news::doUpdate', Controllers::SOURCE_EDITORS),
				route()->delete('/:(num)', 'site.news::doDelete', Controllers::SOURCE_EDITORS),
			]),

			route()->group('/changes', [
				route()->get('', 'site.changes::select', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)', 'site.changes::browse', Controllers::SOURCE_EDITORS),
				route()->get('/create', 'site.changes::create', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)/update', 'site.changes::update', Controllers::SOURCE_EDITORS),
				route()->post('', 'site.changes::doCreate', Controllers::SOURCE_EDITORS),
				route()->patch('/:(num)', 'site.changes::doUpdate', Controllers::SOURCE_EDITORS),
				route()->delete('/:(num)', 'site.changes::doDelete', Controllers::SOURCE_EDITORS),

				route()->group('/:(num)/change', [
					route()->get('', 'site.change::select', Controllers::SOURCE_EDITORS),
					route()->get('/:(num)', 'site.change::browse', Controllers::SOURCE_EDITORS),
					route()->get('/create', 'site.change::create', Controllers::SOURCE_EDITORS),
					route()->get('/:(num)/update', 'site.change::update', Controllers::SOURCE_EDITORS),
					route()->post('', 'site.change::doCreate', Controllers::SOURCE_EDITORS),
					route()->patch('/:(num)', 'site.change::doUpdate', Controllers::SOURCE_EDITORS),
					route()->delete('/:(num)', 'site.change::doDelete', Controllers::SOURCE_EDITORS),
				]),
			]),

			route()->group('/feedback', [
				route()->get('', 'site.feedback::select', Controllers::SOURCE_EDITORS),
				route()->get('/:(num)', 'site.feedback::browse', Controllers::SOURCE_EDITORS),
				route()->delete('/:(num)', 'site.feedback::doDelete', Controllers::SOURCE_EDITORS),
				route()->patch('/:(num)/status/:(num)', 'site.feedback::setState', Controllers::SOURCE_EDITORS),
			]),
		])
			->middleware('clients')
			->middleware('statistics')
			->middleware('admin.authenticationXHR'),

		route()->all('/xhr/:(all)', 'admin.out::error404')
			->middleware('clients')
			->middleware('statistics')
			->middleware('admin.authenticationXHR'),

		route()->empty('/:(all)')
			->middleware('clients')
			->middleware('statistics')
			->middleware('admin.authenticationHTML')
			->middleware('admin.out'),
	]);
