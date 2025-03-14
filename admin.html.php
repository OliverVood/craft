<?php

	declare(strict_types=1);

	use Base\App;

	const POINTER = 'html';

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'require.php';
	require_once DIR_ENTRY_ADMIN . 'route.html.php';

	app('1.0.0', App::ASSEMBLY_DEVELOPMENT, '/admin', '/admin/xhr');

	app()->params->name = 'docroom.pro';
	app()->params->defaultTemplate = 'admin.template';

	access()->regSuperUsers([]);

	require_once DIR_PROJ_FEATURES . 'DB.php';
	require_once DIR_PROJ_FEATURES . 'Users.php';
	require_once DIR_PROJ_FEATURES . 'Authentication.php';
	require_once DIR_PROJ_FEATURES . 'Out.php';

	app()->features->registration(Proj\Features\DB::class, 2, 'dbs', 'Базы данных');
	app()->features->registration(Proj\Features\Users::class, 10, 'users', 'Пользователи');
	app()->features->registration(Proj\Features\Authentication::class, 11, 'authentication', 'Аутентификация');
	app()->features->registration(Proj\Features\Out::class, 20, 'out', 'Вывод');

	app()->links->internal('home', '', /** @lang JavaScript */ "Base.Request.address('').then((result) => { Base.Response.run(result); }); return false;");
	app()->links->external('site', '/');

//	app()->links->right('dbs_check', 'dbs', 'check', '/dbs/check', /** @lang JavaScript */ "Base.Query.sendToAddress('/dbs/check'/*, Admin.General.Render.CheckDB*/); return false;");
//	app()->links->right('dbs_make', 'dbs', 'make', '/dbs/make', /** @lang JavaScript */ "Base.Query.sendToAddress('/dbs/make'/*, Admin.General.Render.CheckDB*/); return false;");
//	app()->links->right('dbs_structure', 'dbs', 'structure', '/dbs/structure', /** @lang JavaScript */ "Base.Query.sendToAddress('/dbs/structure'); return false;");

	app()->links->internal('users_auth', '/users/auth', /* @lang JavaScript */ "Base.Request.submit(this).then(() => { location.reload(); }); return false;");
	app()->links->internal('users_exit', '/users/exit', /* @lang JavaScript */ "Base.Request.address('/users/exit').then(() => { location.reload(); }); return false;");

	route()->run();

	template()->browse();