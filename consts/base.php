<?php

	define('PROTOCOL', (isset($_SERVER['HTTPS'])) ? 'https' : 'http');
	define('ADDRESS', PROTOCOL . '://' . $_SERVER['SERVER_NAME']);