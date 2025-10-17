<?php

	declare(strict_types=1);

	namespace Proj\Middlewares;

	use Base\Middleware;
	use Proj\Models;

	/**
	 * Пользовательское программное обеспечение
	 */
	class Statistics extends Middleware {

		/**
		 * Before
		 * @return void
		 */
		public function inlet(): void {
			/** @var Models\Clients $clients */ $clients = model('clients');
			/** @var Models\Statistics $statistics */ $statistics = model('statistics');

			$clientId = $clients->getId();
			$ip = ip2long(request()->getClientIP());
			$url = request()->url();
			$method = request()->method();
			$methodVirtual = request()->methodVirtual();

			$statistics->addRequest($clientId, $ip, $url, $method, $methodVirtual);
		}

		/**
		 * After
		 * @return void
		 */
		public function outlet(): void {  }

	}
