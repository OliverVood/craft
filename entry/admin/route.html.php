<?php

	Base\Route::set('*::*', 'admin.authorization::isAuthHTML');

	Base\Route::set('*::*', 'admin.out::setHead');
	Base\Route::set('*::*', 'admin.out::setMenu');
	Base\Route::set('*::*', 'admin.out::setFooter');