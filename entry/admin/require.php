<?php

	declare(strict_types=1);

	require DIR_BASE . 'functions.php';

	require DIR_BASE . 'Singleton.php';

	require DIR_BASE . 'App.php';
	require DIR_BASE . 'Request.php';
	require DIR_BASE . 'access/Features.php';
	require DIR_BASE . 'access/Feature.php';
	require DIR_BASE . 'access/Rights.php';
	require DIR_BASE . 'access/Right.php';
	require DIR_BASE . 'access/Links.php';

	require DIR_BASE . 'Route.php';
	require DIR_BASE . 'Controllers.php';
	require DIR_BASE . 'Controller.php';
	require DIR_BASE . 'ControllerAccess.php';
	require DIR_BASE . 'Models.php';
	require DIR_BASE . 'Model.php';
	require DIR_BASE . 'DBs.php';
	require DIR_BASE . 'data/Set.php';
	require DIR_BASE . 'Access.php';

	require DIR_BASE_DB . 'DB.php';

	require DIR_BASE_EDITOR . 'Controller.php';
	require DIR_BASE_EDITOR . 'Model.php';

	require DIR_BASE . 'link/Fundamental.php';
	require DIR_BASE . 'link/External.php';
	require DIR_BASE . 'link/Internal.php';
	require DIR_BASE . 'link/Right.php';

	require DIR_BASE . 'Templates.php';
	require DIR_BASE_UI . 'Template.php';
	require DIR_BASE_UI . 'Layout.php';
	require DIR_BASE_UI . 'Section.php';
	require DIR_BASE_UI . 'SEO.php';
	require DIR_BASE_UI . 'CSS.php';
	require DIR_BASE_UI . 'JS.php';
	require DIR_BASE_UI . 'View.php';
	require DIR_BASE_UI . 'Buffer.php';

	require DIR_BASE_HELPER . 'Translation.php';
	require DIR_BASE_HELPER . 'Response.php';
	require DIR_BASE_HELPER . 'Validator.php';
	require DIR_BASE_HELPER . 'Cryptography.php';
	require DIR_BASE_HELPER . 'Accumulator.php';
	require DIR_BASE_HELPER . 'Pagination.php';
	require DIR_BASE_HELPER . 'Debugger.php';
