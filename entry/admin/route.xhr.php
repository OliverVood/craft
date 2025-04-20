<?php

	declare(strict_types=1);

	use Base\Controllers;

	route()->registration('/admin/xhr/users/auth:[post]', 'admin.users::auth');
	route()->registration('/admin/xhr/:(all)', 'admin.authentication::isAuthXHR');
	route()->registration('/admin/xhr/users/exit:[get]', 'admin.users::exit');

	route()->registration('/admin/xhr:[get]', 'admin.out::home');

	route()->registration('/admin/xhr/dbs/structure:[get]', 'admin.dbs::structure');
	route()->registration('/admin/xhr/dbs/check:[get]', 'admin.dbs::check');
	route()->registration('/admin/xhr/dbs/make:[patch]', 'admin.dbs::make');

	route()->registration('/admin/xhr/statistics/ips:[get]', 'statistics.ips::select', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/statistics/actions:[get]', 'statistics.actions::select', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/groups/:(num)/access:[get]', 'access.groups::access', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups:[get]', 'groups::select', Controllers::SOURCE_EDITORS);
	route()->registration('groups::browse', 'groups::browse', Controllers::SOURCE_EDITORS);
	route()->registration('groups::create', 'groups::create', Controllers::SOURCE_EDITORS);
	route()->registration('groups::update', 'groups::update', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups/:(num)/access:[put]', 'access.groups::doAccess', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_create', 'groups::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_update', 'groups::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('groups::do_delete', 'groups::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/users/:(num)/access:[get]', 'access.users::access', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users:[get]', 'users::select', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users/:(num):[get]', 'users::browse', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users/create:[get]', 'users::create', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users/:(num)/update:[get]', 'users::update', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users/:(num)/access:[put]', 'access.users::doAccess', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users:[post]', 'users::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users/:(num):[patch]', 'users::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/users/:(num):[delete]', 'users::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/news:[get]', 'site.news::select', Controllers::SOURCE_EDITORS);
	route()->registration('news::browse', 'site.news::browse', Controllers::SOURCE_EDITORS);
	route()->registration('news::create', 'site.news::create', Controllers::SOURCE_EDITORS);
	route()->registration('news::update', 'site.news::update', Controllers::SOURCE_EDITORS);
	route()->registration('news::do_create', 'site.news::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('news::do_update', 'site.news::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('news::do_delete', 'site.news::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/changes:[get]', 'site.changes::select', Controllers::SOURCE_EDITORS);
	route()->registration('changes::browse', 'site.changes::browse', Controllers::SOURCE_EDITORS);
	route()->registration('changes::create', 'site.changes::create', Controllers::SOURCE_EDITORS);
	route()->registration('changes::update', 'site.changes::update', Controllers::SOURCE_EDITORS);
	route()->registration('changes::do_create', 'site.changes::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('changes::do_update', 'site.changes::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('changes::do_delete', 'site.changes::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/changes/:(num)/change:[get]', 'site.change::select', Controllers::SOURCE_EDITORS);
	route()->registration('change::browse', 'site.change::browse', Controllers::SOURCE_EDITORS);
	route()->registration('change::create', 'site.change::create', Controllers::SOURCE_EDITORS);
	route()->registration('change::update', 'site.change::update', Controllers::SOURCE_EDITORS);
	route()->registration('change::do_create', 'site.change::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('change::do_update', 'site.change::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('change::do_delete', 'site.change::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/feedback:[get]', 'site.feedback::select', Controllers::SOURCE_EDITORS);
	route()->registration('feedback::browse', 'site.feedback::browse', Controllers::SOURCE_EDITORS);
	route()->registration('feedback::do_delete', 'site.feedback::doDelete', Controllers::SOURCE_EDITORS);
	route()->registration('feedback::set_state', 'site.feedback::setState', Controllers::SOURCE_EDITORS);