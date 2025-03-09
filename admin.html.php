<?php

	declare(strict_types=1);

	use Base\App;

//	use Base\Template\Template as BaseTemplate;
//	use Proj\Templates\Admin\Template as AdminTemplate;
//	use Proj\Configs;
//	use Proj\DB;

	const POINTER = 'html';

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'require.php';
	require_once DIR_ENTRY_ADMIN . 'route.html.php';

//	require_once DIR_PROJ_CONFIGS . 'db.php';
//	require_once DIR_PROJ_CONFIGS . 'user.php';
//
//	require_once DIR_PROJ_PARAMS . 'site.php';
//
//	require_once DIR_PROJ_LINKS . 'admin.php';
//	require_once DIR_PROJ_SETTINGS . 'admin.php';
//
//	require_once DIR_PROJ_DB . 'Craft.php';
//	require_once DIR_PROJ_DB . 'Craft2.php';
////	require_once DIR_PROJ_DB . 'Versions.php';
//

	app('1.0.0', App::ASSEMBLY_DEVELOPMENT, '/admin', '/admin/xhr');

	require_once DIR_PROJ_FEATURES . 'DB.php';
	require_once DIR_PROJ_FEATURES . 'Users.php';
	require_once DIR_PROJ_FEATURES . 'Authentication.php';
	require_once DIR_PROJ_FEATURES . 'Out.php';

	app()->features->registration(Proj\Features\DB::class, 2, 'dbs', 'Базы данных');
	app()->features->registration(Proj\Features\Users::class, 10, 'users', 'Пользователи');
	app()->features->registration(Proj\Features\Authentication::class, 11, 'authentication', 'Аутентификация');
	app()->features->registration(Proj\Features\Out::class, 20, 'out', 'Вывод');

	app()->links->right('dbs_check', 'dbs', 'check', '/dbs/check', /** @lang JavaScript */ "Base.Query.sendToAddress('/dbs/check'/*, Admin.General.Render.CheckDB*/); return false;");
	app()->links->right('dbs_make', 'dbs', 'make', '/dbs/make', /** @lang JavaScript */ "Base.Query.sendToAddress('/dbs/make'/*, Admin.General.Render.CheckDB*/); return false;");
	app()->links->right('dbs_structure', 'dbs', 'structure', '/dbs/structure', /** @lang JavaScript */ "Base.Query.sendToAddress('/dbs/structure'); return false;");

	app()->links->internal('users_auth', '/users/auth', /* @lang JavaScript */ "Base.Query.submitForm(this, () => location.reload()); return false;");
	app()->links->internal('users_exit', '/users/exit', /* @lang JavaScript */ "Base.Query.sendToAddress('/users/exit', () => location.reload()); return false;");

//	DB\Craft::init(Configs\DB_HOST, Configs\DB_NAME, Configs\DB_USER, Configs\DB_PASS);
//	DB\Craft2::init('MySQL-8.0', 'craft2', 'root', '');
////	DB\Versions::init();
//
//	BaseTemplate::load('admin');
//
//	AdminTemplate::init();
//

	route()->run();

//
//	AdminTemplate::browse();