<?php

	use Base\Route;
	use Base\Template\Template as BaseTemplate;
	use Proj\Templates\Admin\Template as AdminTemplate;
	use Proj\Configs;
	use Proj\DB;

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/assembly.php';
	require_once DIR_ROOT . 'consts/base.php';
	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'consts.php';
	require_once DIR_ENTRY_ADMIN . 'require.php';
	require_once DIR_ENTRY_ADMIN . 'route.xhr.php';
	require_once DIR_ENTRY_ADMIN . 'collections.php';

	require_once DIR_PROJ_CONFIGS . 'db.php';
	require_once DIR_PROJ_CONFIGS . 'user.php';
	require_once DIR_PROJ_LINKS . 'admin.php';
	require_once DIR_PROJ_SETTINGS . 'admin.php';

	require_once DIR_PROJ_DB . 'Craft.php';
	require_once DIR_PROJ_DB . 'Craft2.php';
//	require_once DIR_PROJ_DB . 'Versions.php';

	session_start();

	DB\Craft::init(Configs\DB_HOST, Configs\DB_NAME, Configs\DB_USER, Configs\DB_PASS);
	DB\Craft2::init('MySQL-8.0', 'craft2', 'root', '');
//	DB\Versions::init();

	BaseTemplate::load('admin');

	AdminTemplate::init();

	Route::prepare($_REQUEST['__url'] ?? '');
	Route::run();

	AdminTemplate::browse();