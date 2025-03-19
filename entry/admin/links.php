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