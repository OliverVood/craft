<?php

	Base\Route::set('user::auth', 'admin.user::auth');

	Base\Route::set('*::*', 'admin.base::isAuth');