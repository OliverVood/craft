<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Маршрутизатор
	 */
	class Route {
		use Singleton;

		private array $stack = [];

		private function __construct() {  }

		/**
		 * Регистрирует контроллер
		 * @param string $customer - Адреса
		 * @param string $performer - Обработчик
		 * @param int $source - Источник
		 * @return void
		 */
		public function registration(string $customer, string $performer, int $source = Controllers::SOURCE_CONTROLLERS): void {
			$this->stack[] = ['customer' => $customer, 'performer' => $performer, 'source' => $source];
		}

		/**
		 * Выполняет маршрутизацию
		 * @return void
		 */
		public function run(): void {
			foreach ($this->stack as $item) {
				$customer = $item['customer'];
				$performer = $item['performer'];
				$source = $item['source'];

				$method = '*';
				preg_match('/:\[(get|post|put|delete|patch|\*)]/', $customer, $matches);
				if ($matches) {
					$method = $matches[1];
					$customer = str_replace($matches[0], '', $customer);
				}
				if (!in_array($method, ['*', request()->methodVirtual()])) continue;
				if (request()->methodVirtual() != 'get' && !csrfValidate()) app()->error(new Exception('Invalid csrf token'));

				$customer = parse_url($customer, PHP_URL_PATH);
				$customer = explode('/', $customer);

				$url = parse_url(request()->url(), PHP_URL_PATH);
				$url = explode('/', $url);

				$params = [];

				$isAll = false;
				foreach ($customer as $key => $value) {
					if ($value == ':(all)') { $isAll = true; break; }
					if (!isset($url[$key])) continue 2;

					switch ($value) {
						case ':(num)': $params[] = (int)$url[$key]; if (!is_numeric($url[$key])) continue 3; break;
						case ':(str)': $params[] = $url[$key]; if (!is_string($url[$key])) continue 3; break;
						case ':(any)': $params[] = $url[$key]; break;
						default: if ($value != $url[$key]) continue 3;
					}
				}

				if (!$isAll && (count($customer) != count($url))) continue;

				$parts = explode('::', $performer);
				$controller = $parts[0];
				$call = $parts[1] ?? '';

				app()->controllers->run($source, $controller, $call, $params);
			}
		}

	}