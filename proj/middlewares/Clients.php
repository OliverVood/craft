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
		 * @return void
		 */
		public function inlet(): void {
			/** @var \Proj\Models\Clients $model */ $model = model('clients');

			$model->init();
		}

		/**
		 * After
		 * @return void
		 */
		public function outlet(): void {  }

	}
