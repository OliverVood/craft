<?php

	declare(strict_types=1);

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'require.php';
	require_once DIR_ENTRY_ADMIN . 'route.xhr.php';

	app('/admin', '/admin/xhr');

	app()->config()->load('app');
	app()->config()->load('db');

	app()->params->name = 'docroom.pro';

	access()->regSuperUsers([]);

	require_once DIR_ENTRY_ADMIN . 'features.php';
	require_once DIR_ENTRY_ADMIN . 'links.php';

	route()->run();

	response()->notFound(__('Страница не найдена'));