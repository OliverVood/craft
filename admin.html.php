<?php

	declare(strict_types=1);

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'require.php';

	config()->load('app');
	config()->load('db');

	app('/admin/', '/admin/xhr/');

	require_once DIR_ENTRY_ADMIN . 'route.php';
	require_once DIR_ENTRY_ADMIN . 'features.php';
	require_once DIR_ENTRY_ADMIN . 'links.php';

	app()->params->name = 'docroom.pro';
	app()->params->defaultTemplate = 'admin.template';//todo из конфига

	access()->regSuperUsers([]);

	route()->run();