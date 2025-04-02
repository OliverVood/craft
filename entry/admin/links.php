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

	app()->links->right('groups_access', 'groups', 'access', '/groups/access?id=:[id]', /* @lang JavaScript */"Base.Request.data('/groups/access', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_select', 'groups', 'select', '/groups/select?page=:[page]', /* @lang JavaScript */"Base.Request.data('/groups/select', {page: ':[page]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_browse', 'groups', 'browse', '/groups/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/groups/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_create', 'groups', 'create', '/groups/create', /* @lang JavaScript */"Base.Request.address('/groups/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_update', 'groups', 'update', '/groups/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/groups/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_access', 'groups', 'access', '/groups/do_access', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_create', 'groups', 'create', '/groups/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_update', 'groups', 'update', '/groups/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_delete', 'groups', 'delete', '/groups/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить?'))) Base.Request.data('/groups/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('users_access', 'users', 'access', '/users/access?id=:[id]', /* @lang JavaScript */"Base.Request.data('/users/access', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_select', 'users', 'select', '/users/select?page=:[page]', /* @lang JavaScript */"Base.Request.data('/users/select', {page: ':[page]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_browse', 'users', 'browse', '/users/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/users/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_create', 'users', 'create', '/users/create', /* @lang JavaScript */"Base.Request.address('/users/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_update', 'users', 'update', '/users/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/users/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_access', 'users', 'access', '/users/do_access', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_create', 'users', 'create', '/users/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_update', 'users', 'update', '/users/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_delete', 'users', 'delete', '/users/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить?'))) Base.Request.data('/users/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");



	//		protected function regLinkSetState(): void { $this->set_state = new LinkAccess($this->id, self::ACCESS_STATE, $this->name, 'set_state', "/{$this->name}/set_state?id=%id%&state=%state%", /* @lang JavaScript */ "if (confirm('{$this->textSetStateConfirm}')) Base.Query.send('/{$this->name}/set_state', {id: '%id%', state: '%state%'}); return false;"); }