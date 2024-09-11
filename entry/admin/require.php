<?php

	require DIR_BASE . 'functions.php';

	require DIR_BASE . 'Instance.php';

	require DIR_BASE . 'Debugger.php';

	require DIR_BASE . 'data/set/Input.php';

	require DIR_BASE . 'Route.php';
	require DIR_BASE . 'Collection.php';
	require DIR_BASE . 'Controller.php';
	require DIR_BASE . 'ControllerAccess.php';
	require DIR_BASE . 'Model.php';

	require DIR_BASE . 'Access.php';

	require DIR_BASE . 'link/External.php';
	require DIR_BASE . 'link/Internal.php';
	require DIR_BASE . 'link/Right.php';

	require DIR_BASE . 'helper/Response.php';

	require DIR_BASE_TEMPLATE . 'Buffer.php';
	require DIR_BASE_TEMPLATE . 'Template.php';
	require DIR_BASE_TEMPLATE . 'Layout.php';
	require DIR_BASE_TEMPLATE . 'Section.php';
	require DIR_BASE_TEMPLATE . 'JS.php';
	require DIR_BASE_TEMPLATE . 'CSS.php';
	require DIR_BASE_TEMPLATE . 'SEO.php';

	require_once DIR_BASE_DB . 'DB.php';
	require_once DIR_BASE_DB . 'driver/MySQLi/DB.php';
//	require_once DIR_BASE_DB . 'driver/SQLite/DB.php';

	require_once DIR_BASE . 'View.php';