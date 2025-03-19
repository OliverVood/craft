<?php

	declare(strict_types=1);

	use Base\App;

	const POINTER = 'xhr';

	const DIR_ROOT = __DIR__ . '/';

	require_once DIR_ROOT . 'consts/dirs.php';

	require_once DIR_ENTRY_ADMIN . 'require.php';
	require_once DIR_ENTRY_ADMIN . 'route.xhr.php';

	app('1.0.0', App::ASSEMBLY_DEVELOPMENT, '/admin', '/admin/xhr');

	app()->params->name = 'docroom.pro';

	access()->regSuperUsers([]);

	require_once DIR_ENTRY_ADMIN . 'features.php';
	require_once DIR_ENTRY_ADMIN . 'links.php';

	route()->run();