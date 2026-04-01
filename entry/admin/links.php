<?php

	declare(strict_types=1);

	$csrf = app()->csrf();

	#region page
	linkRegInternal('home', '', /** @lang JavaScript */ "Base.Request.get('').then(result => Base.Response.execute(result)); return false;");
	linkRegExternal('site', '/');
	#endregion page

	#region dbs
	linkRegRight('dbs_check', 'dbs', 'check', 'dbs/check', /** @lang JavaScript */ "Base.Request.get('dbs/check').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('dbs_make', 'dbs', 'make', 'dbs/make');
	linkRegRight('dbs_structure', 'dbs', 'structure', 'dbs/structure', /** @lang JavaScript */ "Base.Request.get('dbs/structure').then(result => Base.Response.execute(result)); return false;");
	#endregion dbs

	#region auth
	linkRegInternal('users_auth', 'users/auth', /* @lang JavaScript */ "Base.Request.submit(this).then(() => { location.reload(); }); return false;");
	linkRegInternal('users_exit', 'users/exit', /* @lang JavaScript */ "Base.Request.get('users/exit').then(() => { location.reload(); }); return false;");
	#endregion auth

	#region statistics
	linkRegRight('statistics_ips_select', 'statistics_ips', 'select', "statistics/ips?page=:[page]", /* @lang JavaScript */"Base.Request.get('statistics/ips?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('statistics_actions_select', 'statistics_actions', 'select', "statistics/actions?page=:[page]", /* @lang JavaScript */"Base.Request.get('statistics/actions?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	#endregion statistics

	#region groups
	linkRegRight('groups_access', 'groups', 'access', 'groups/:[id]/access', /* @lang JavaScript */"Base.Request.get('groups/:[id]/access').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_select', 'groups', 'select', 'groups?page=:[page]', /* @lang JavaScript */"Base.Request.get('groups?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_browse', 'groups', 'browse', 'groups/:[id]', /* @lang JavaScript */"Base.Request.get('groups/:[id]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_create', 'groups', 'create', 'groups/create', /* @lang JavaScript */"Base.Request.get('groups/create').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_update', 'groups', 'update', 'groups/:[id]/update', /* @lang JavaScript */"Base.Request.get('groups/:[id]/update').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_do_access', 'groups', 'access', 'groups/:[id]/access', /* @lang JavaScript */ "Base.Request.submit(this, {method: 'put', json: true}).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_do_create', 'groups', 'create', 'groups', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_do_update', 'groups', 'update', 'groups/:[id]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('groups_do_delete', 'groups', 'delete', 'groups/:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить группу?'))) Base.Request.delete('groups/:[id]', {__csrf: '{$csrf}'}).then(result => Base.Response.execute(result)); return false;");
	#endregion groups

	#region users
	linkRegRight('users_access', 'users', 'access', 'users/:[id]/access', /* @lang JavaScript */"Base.Request.get('users/:[id]/access').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_select', 'users', 'select', 'users?page=:[page]', /* @lang JavaScript */"Base.Request.get('users?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_browse', 'users', 'browse', 'users/:[id]', /* @lang JavaScript */"Base.Request.get('users/:[id]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_create', 'users', 'create', 'users/create', /* @lang JavaScript */"Base.Request.get('users/create').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_update', 'users', 'update', 'users/:[id]/update', /* @lang JavaScript */"Base.Request.get('users/:[id]/update').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_do_access', 'users', 'access', 'users/:[id]/access', /* @lang JavaScript */ "Base.Request.submit(this, {method: 'put', json: true}).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_do_create', 'users', 'create', 'users', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_do_update', 'users', 'update', 'users/:[id]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('users_do_delete', 'users', 'delete', 'users/:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить пользователя?'))) Base.Request.delete('users/:[id]', {__csrf: '{$csrf}'}).then(result => Base.Response.execute(result)); return false;");
	#endregion users

	#region craft
	linkRegRight('craft_documentation', 'craft', 'select', 'craft/documentation', /* @lang JavaScript */ "Base.Request.get('craft/documentation').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('craft_help', 'craft', 'select', 'craft/help', /* @lang JavaScript */ "Base.Request.get('craft/help').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('craft_action', 'craft', 'update', 'craft/:[entity]/:[action]', /* @lang JavaScript */ "Base.Request.get('craft/:[entity]/:[action]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('craft_run', 'craft', 'update', 'craft/:[entity]/:[action]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	#endregion craft

	#region languages
	linkRegEditorSelect('languages', 'locales/languages?page=:[page]');
	linkRegEditorBrowse('languages', 'locales/languages/:[id]');
	linkRegEditorCreate('languages', 'locales/languages/create');
	linkRegEditorUpdate('languages', 'locales/languages/:[id]/update');
	linkRegEditorDelete('languages', 'locales/languages/:[id]/delete', 'locales/languages/:[id]');

	linkRegEditorDoCreate('languages', 'locales/languages');
	linkRegEditorDoUpdate('languages', 'locales/languages/:[id]');
	linkRegEditorDoDelete('languages', 'locales/languages/:[id]', __('Удалить язык?'));
	#endregion languages

	#region contexts
	linkRegEditorSelect('contexts', 'locales/contexts?page=:[page]');
	linkRegEditorBrowse('contexts', 'locales/contexts/:[id]');
	linkRegEditorCreate('contexts', 'locales/contexts/create');
	linkRegEditorUpdate('contexts', 'locales/contexts/:[id]/update');
	linkRegEditorDelete('contexts', 'locales/contexts/:[id]/delete', 'locales/contexts/:[id]', __('Delete context?'));

	linkRegEditorDoCreate('contexts', 'locales/contexts');
	linkRegEditorDoUpdate('contexts', 'locales/contexts/:[id]');
	linkRegEditorDoDelete('contexts', 'locales/contexts/:[id]', __('Delete context?'));
	#endregion contexts

	#region aliases
	linkRegEditorSelect('aliases', 'locales/aliases?page=:[page]');
	linkRegEditorBrowse('aliases', 'locales/aliases/:[id]');
	linkRegEditorCreate('aliases', 'locales/aliases/create');
	linkRegEditorUpdate('aliases', 'locales/aliases/:[id]/update');
	linkRegEditorDelete('aliases', 'locales/aliases/:[id]/delete', 'locales/aliases/:[id]', __('Delete alias?'));

	linkRegEditorDoCreate('aliases', 'locales/aliases');
	linkRegEditorDoUpdate('aliases', 'locales/aliases/:[id]');
	linkRegEditorDoDelete('aliases', 'locales/aliases/:[id]', __('Delete alias?'));
	#endregion aliases

	#region translates
	linkRegEditorSelect('translations', 'locales/translations?page=:[page]');
//	linkRegEditorBrowse('translates', 'locales/translates/:[id]');
//	linkRegEditorCreate('translates', 'locales/translates/create');
//	linkRegEditorUpdate('translates', 'locales/translates/:[id]/update');
//	linkRegEditorDelete('translates', 'locales/translates/:[id]/delete', 'locales/translates/:[id]', __('Delete translate?'));
//
//	linkRegEditorDoCreate('translates', 'locales/translates');
//	linkRegEditorDoUpdate('translates', 'locales/translates/:[id]');
//	linkRegEditorDoDelete('translates', 'locales/translates/:[id]', __('Delete translate?'));
	#endregion translates

	#region news
	linkRegRight('news_select', 'news', 'select', 'news?page=:[page]', /* @lang JavaScript */"Base.Request.get('news?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('news_browse', 'news', 'browse', 'news/:[id]', /* @lang JavaScript */"Base.Request.get('news/:[id]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('news_create', 'news', 'create', 'news/create', /* @lang JavaScript */"Base.Request.get('news/create').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('news_update', 'news', 'update', 'news/:[id]/update', /* @lang JavaScript */"Base.Request.get('news/:[id]/update').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('news_do_create', 'news', 'create', 'news', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('news_do_update', 'news', 'update', 'news/:[id]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('news_do_delete', 'news', 'delete', 'news/:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить новость?'))) Base.Request.delete('news/:[id]', {__csrf: '{$csrf}'}).then(result => Base.Response.execute(result)); return false;");
	#endregion news

	#region changes
	linkRegRight('changes_select', 'changes', 'select', 'changes?page=:[page]', /* @lang JavaScript */"Base.Request.get('changes?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('changes_browse', 'changes', 'browse', 'changes/:[id]', /* @lang JavaScript */"Base.Request.get('changes/:[id]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('changes_create', 'changes', 'create', 'changes/create', /* @lang JavaScript */"Base.Request.get('changes/create').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('changes_update', 'changes', 'update', 'changes/:[id]/update', /* @lang JavaScript */"Base.Request.get('changes/:[id]/update').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('changes_do_create', 'changes', 'create', 'changes', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('changes_do_update', 'changes', 'update', 'changes/:[id]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('changes_do_delete', 'changes', 'delete', 'changes/:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить изменения?'))) Base.Request.delete('changes/:[id]', {__csrf: '{$csrf}'}).then(result => Base.Response.execute(result)); return false;");
	#endregion changes

	#region change
	linkRegRight('change_select', 'changes', 'select', 'changes/:[changes]/change', /* @lang JavaScript */"Base.Request.get('changes/:[changes]/change').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('change_browse', 'changes', 'browse', 'changes/:[changes]/change/:[id]', /* @lang JavaScript */"Base.Request.get('changes/:[changes]/change/:[id]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('change_create', 'changes', 'create', 'changes/:[changes]/change/create', /* @lang JavaScript */"Base.Request.get('changes/:[changes]/change/create').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('change_update', 'changes', 'update', 'changes/:[changes]/change/:[id]/update', /* @lang JavaScript */"Base.Request.get('changes/:[changes]/change/:[id]/update').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('change_do_create', 'changes', 'create', 'changes/:[changes]/change', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('change_do_update', 'changes', 'update', 'changes/:[changes]/change/:[id]', /* @lang JavaScript */ "Base.Request.submit(this).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('change_do_delete', 'changes', 'delete', 'changes/:[changes]/change/:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить изменение?'))) Base.Request.delete('changes/:[changes]/change/:[id]', {__csrf: '{$csrf}'}).then(result => Base.Response.execute(result)); return false;");
	#endregion change

	#region feedback
	linkRegRight('feedback_select', 'feedback', 'select', 'feedback?page=:[page]', /* @lang JavaScript */"Base.Request.get('feedback?page=:[page]').then(result => Base.Response.execute(result)); return false;");
	linkRegRight('feedback_browse', 'feedback', 'browse', 'feedback/:[id]', /* @lang JavaScript */"Base.Request.get('feedback/:[id]').then(result => Base.Response.execute(result)); return false;");
//	linkRegRight('feedback_do_delete', 'feedback', 'delete', 'feedback/:[id]', /* @lang JavaScript */ "if (confirm(__('Удалить запись?'))) Base.Request.delete('feedback/:[id]', {__csrf: '{$csrf}'}).then(result => Base.Response.execute(result)); return false;");
	linkRegRight('feedback_do_delete', 'feedback', 'delete', 'feedback/:[id]', /* @lang JavaScript */ "new Base.UI.Window('head', 'text'); return false;");
	linkRegRight('feedback_set_state', 'feedback', 'status', 'feedback/:[id]/status/:[status]', /* @lang JavaScript */ "if (confirm(__('Проверить запись?'))) Base.Request.data('feedback/:[id]/status/:[status]', {__csrf: '{$csrf}'}, {method: 'patch'}).then(result => Base.Response.execute(result)); return false;");
	#endregion feedback