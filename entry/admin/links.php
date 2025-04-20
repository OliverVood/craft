<?php

	declare(strict_types=1);

	app()->links->internal('home', '', /** @lang JavaScript */ "Base.Request.get('').then(result => Base.Response.execute(result)); return false;");
	app()->links->external('site', '/');

	app()->links->right('dbs_check', 'dbs', 'check', '/dbs/check', /** @lang JavaScript */ "Base.Request.get('/dbs/check').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('dbs_make', 'dbs', 'make', '/dbs/make');
	app()->links->right('dbs_structure', 'dbs', 'structure', '/dbs/structure', /** @lang JavaScript */ "Base.Request.get('/dbs/structure').then(result => Base.Response.execute(result)); return false;");

	app()->links->internal('users_auth', '/users/auth', /* @lang JavaScript */ "Base.Request.submit(this).then(() => { location.reload(); }); return false;");
	app()->links->internal('users_exit', '/users/exit', /* @lang JavaScript */ "Base.Request.get('/users/exit').then(() => { location.reload(); }); return false;");

	app()->links->right('statistics_ips_select', 'statistics_ips', 'select', "/statistics/ips?page=:[page]", /* @lang JavaScript */"Base.Request.get('/statistics/ips?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('statistics_actions_select', 'statistics_actions', 'select', "/statistics/actions?page=:[page]", /* @lang JavaScript */"Base.Request.get('/statistics/actions?page=:[page]').then(result => Base.Response.execute(result)); return false;");

	app()->links->right('groups_access', 'groups', 'access', '/groups/:[id]/access', /* @lang JavaScript */"Base.Request.get('/groups/:[id]/access').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_select', 'groups', 'select', '/groups?page=:[page]', /* @lang JavaScript */"Base.Request.get('/groups?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_browse', 'groups', 'browse', '/groups/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/groups/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_create', 'groups', 'create', '/groups/create', /* @lang JavaScript */"Base.Request.address('/groups/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_update', 'groups', 'update', '/groups/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/groups/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_access', 'groups', 'access', '/groups/:[id]/access', /* @lang JavaScript */ "Base.Request.submit(this, {method: 'put', json: true}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_create', 'groups', 'create', '/groups/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_update', 'groups', 'update', '/groups/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('groups_do_delete', 'groups', 'delete', '/groups/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить группу?'))) Base.Request.data('/groups/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('users_access', 'users', 'access', '/users/:[id]/access', /* @lang JavaScript */"Base.Request.get('/users/:[id]/access').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_select', 'users', 'select', '/users?page=:[page]', /* @lang JavaScript */"Base.Request.get('/users?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_browse', 'users', 'browse', '/users/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/users/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_create', 'users', 'create', '/users/create', /* @lang JavaScript */"Base.Request.get('/users/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_update', 'users', 'update', '/users/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/users/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_access', 'users', 'access', '/users/:[id]/access', /* @lang JavaScript */ "Base.Request.submit(this, {method: 'put', json: true}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_create', 'users', 'create', '/users/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_update', 'users', 'update', '/users/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('users_do_delete', 'users', 'delete', '/users/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить пользователя?'))) Base.Request.data('/users/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('news_select', 'news', 'select', '/news?page=:[page]', /* @lang JavaScript */"Base.Request.get('/news?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('news_browse', 'news', 'browse', '/news/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/news/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('news_create', 'news', 'create', '/news/create', /* @lang JavaScript */"Base.Request.address('/news/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('news_update', 'news', 'update', '/news/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/news/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('news_do_create', 'news', 'create', '/news/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('news_do_update', 'news', 'update', '/news/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('news_do_delete', 'news', 'delete', '/news/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить новость?'))) Base.Request.data('/news/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('changes_select', 'changes', 'select', '/changes?page=:[page]', /* @lang JavaScript */"Base.Request.get('/changes?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('changes_browse', 'changes', 'browse', '/changes/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/changes/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('changes_create', 'changes', 'create', '/changes/create', /* @lang JavaScript */"Base.Request.address('/changes/create').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('changes_update', 'changes', 'update', '/changes/update?id=:[id]', /* @lang JavaScript */"Base.Request.data('/changes/update', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('changes_do_create', 'changes', 'create', '/changes/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('changes_do_update', 'changes', 'update', '/changes/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('changes_do_delete', 'changes', 'delete', '/changes/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить изменения?'))) Base.Request.data('/changes/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('change_select', 'changes', 'select', '/changes/:[changes]/change', /* @lang JavaScript */"Base.Request.get('/changes/:[changes]/change').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('change_browse', 'changes', 'browse', '/change/browse?changes=:[changes]&id=:[id]', /* @lang JavaScript */"Base.Request.data('/change/browse', {changes: ':[changes]', id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('change_create', 'changes', 'create', '/change/create?changes=:[changes]', /* @lang JavaScript */"Base.Request.data('/change/create', {changes: ':[changes]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('change_update', 'changes', 'update', '/change/update?changes=:[changes]&id=:[id]', /* @lang JavaScript */"Base.Request.data('/change/update', {changes: ':[changes]', id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('change_do_create', 'changes', 'create', '/change/do_create', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('change_do_update', 'changes', 'update', '/change/do_update', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('change_do_delete', 'changes', 'delete', '/change/do_delete?changes=:[changes]&id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить изменение?'))) Base.Request.data('/change/do_delete', {changes: ':[changes]', id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");

	app()->links->right('feedback_select', 'feedback', 'select', '/feedback?page=:[page]', /* @lang JavaScript */"Base.Request.get('/feedback?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	app()->links->right('feedback_browse', 'feedback', 'browse', '/feedback/browse?id=:[id]', /* @lang JavaScript */"Base.Request.data('/feedback/browse', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('feedback_do_delete', 'feedback', 'delete', '/feedback/do_delete?id=:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить запись?'))) Base.Request.data('/feedback/do_delete', {id: ':[id]'}).then(result => Base.Response.execute(result)); return false;");
	app()->links->right('feedback_set_state', 'feedback', 'status', '/feedback/set_state?id=:[id]&status=:[status]', /* @lang JavaScript */ "if (confirm(__('Проверить запись?'))) Base.Request.data('/feedback/set_state', {id: ':[id]', state: ':[status]'}).then(result => Base.Response.execute(result)); return false;");