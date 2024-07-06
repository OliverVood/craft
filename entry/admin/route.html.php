<?php

	Base\Route::set('*::*', 'admin.base::isAuth');

	Base\Route::set('*::*', 'admin.base::footer');