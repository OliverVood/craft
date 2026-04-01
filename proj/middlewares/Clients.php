<?php

	declare(strict_types=1);

	namespace Proj\Middlewares;

	use Base\Middleware;

	/**
	 * Пользовательское программное обеспечение
	 */
	class Clients extends Middleware {
		/**
		 * Before
		 * @return bool
		 */
		public function inlet(): bool {
			/** @var \Proj\Models\Clients $model */ $model = model('clients');

			$model->init();

			return true;
		}

		/**
		 * After
		 * @return bool
		 */
		public function outlet(): bool {
			return true;
		}

	}
