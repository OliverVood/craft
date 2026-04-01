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
		 * @return bool
		 */
		public function inlet(): bool {
			/** @var Models\Clients $clients */ $clients = model('clients');
			/** @var Models\Statistics $statistics */ $statistics = model('statistics');

			$clientId = $clients->getId();
			$ip = ip2long(request()->getClientIP());
			$url = request()->url();
			$method = request()->method();
			$methodVirtual = request()->methodVirtual();

			$statistics->addRequest($clientId, $ip, $url, $method, $methodVirtual);

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
