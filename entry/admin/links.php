<?php

	declare(strict_types=1);

	app()->links->internal('home', '', /** @lang JavaScript */ "Base.Request.address('').then(result => Base.Response.execute(result)); return false;");
	app()->links->external('site', '/');

	app()->links->right('dbs_check', 'dbs', 'check', '/dbs/check', /** @lang JavaScript */ "Base.Request.address('/dbs/check').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('dbs_make', 'dbs', 'make', '/dbs/make');
	app()->links->right('dbs_structure', 'dbs', 'structure', '/dbs/structure', /** @lang JavaScript */ "Base.Request.address('/dbs/structure').then(result => Base.Response.execute(result)); return false;");

	app()->links->internal('users_auth', '/users/auth', /* @lang JavaScript */ "Base.Request.submit(this).then(() => { location.reload(); }); return false;");
	app()->links->internal('users_exit', '/users/exit', /* @lang JavaScript */ "Base.Request.address('/users/exit').then(() => { location.reload(); }); return false;");

	app()->links->right('statistics_ips_select', 'statistics_ips', 'select', "/statistics_ips/select?page=:[page]", /* @lang JavaScript */"Base.Request.data('/statistics_ips/select', {page: ':[page]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('statistics_actions_select', 'statistics_actions', 'select', "/statistics_actions/select?page=:[page]", /* @lang JavaScript */"Base.Request.data('/statistics_actions/select', {page: ':[page]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('groups_select', 'groups', 'select', '/groups/select?page=:[page]', /* @lang JavaScript */"Base.Request.data('/groups/select', {page: ':[page]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_create', 'groups', 'create', '/groups/create', /* @lang JavaScript */"Base.Request.address('/groups/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_update', 'groups', 'update', '/groups/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/groups/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_create', 'groups', 'create', '/groups/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_update', 'groups', 'update', '/groups/do_update?id=:[id]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_delete', 'groups', 'delete', '/groups/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить?'))) Base.Request.data('/groups/do_delete', {id: ':[id'}).then(result => Base.Response.execute(result)); return false;");
