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
	route()->registration('/admin/xhr/groups/:(num):[get]', 'groups::browse', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups/create:[get]', 'groups::create', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups/:(num)/update:[get]', 'groups::update', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups/:(num)/access:[put]', 'access.groups::doAccess', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups:[post]', 'groups::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups/:(num):[patch]', 'groups::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/groups/:(num):[delete]', 'groups::doDelete', Controllers::SOURCE_EDITORS);

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
	route()->registration('/admin/xhr/news/:(num):[get]', 'site.news::browse', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/news/create:[get]', 'site.news::create', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/news/:(num)/update:[get]', 'site.news::update', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/news:[post]', 'site.news::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/news/:(num):[patch]', 'site.news::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/news/:(num):[delete]', 'site.news::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/changes:[get]', 'site.changes::select', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num):[get]', 'site.changes::browse', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/create:[get]', 'site.changes::create', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/update:[get]', 'site.changes::update', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes:[post]', 'site.changes::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num):[patch]', 'site.changes::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num):[delete]', 'site.changes::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/changes/:(num)/change:[get]', 'site.change::select', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/change/:(num):[get]', 'site.change::browse', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/change/create:[get]', 'site.change::create', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/change/:(num)/update:[get]', 'site.change::update', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/change:[post]', 'site.change::doCreate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/change/:(num):[patch]', 'site.change::doUpdate', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/changes/:(num)/change/:(num):[delete]', 'site.change::doDelete', Controllers::SOURCE_EDITORS);

	route()->registration('/admin/xhr/feedback:[get]', 'site.feedback::select', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/feedback/:(num):[get]', 'site.feedback::browse', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/feedback/:(num):[delete]', 'site.feedback::doDelete', Controllers::SOURCE_EDITORS);
	route()->registration('/admin/xhr/feedback/:(num)/status/:(num):[patch]', 'site.feedback::setState', Controllers::SOURCE_EDITORS);