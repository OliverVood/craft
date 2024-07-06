<?php

	use Base\Route;
	use Base\Template\Template as BaseTemplate;
	use Proj\Templates\Admin\Template as AdminTemplate;

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/base.php';
	require_once DIR_ROOT . 'consts/assembly.php';
	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'consts.php';
	require_once DIR_ENTRY_ADMIN . 'require.php';
	require_once DIR_ENTRY_ADMIN . 'route.xhr.php';

	require_once DIR_PROJ_CONFIG . 'admin.php';
	require_once DIR_PROJ_LINKS . 'admin.php';

	BaseTemplate::load('admin');

	AdminTemplate::init();

	Route::prepare($_REQUEST['__url'] ?? '');
	Route::run();

	AdminTemplate::browse();