<?php

	declare(strict_types=1);

	namespace Base;

	use Exception;

	/**
	 * Маршрутизатор
	 */
	class Route {
		use Singleton;

		private string $entity = 'main';
		private string $action = 'index';

		private array $stack = [];

		/**
		 * @throws Exception
		 */
		private function __construct() {
			$parts = explode('/', $_REQUEST['__url'] ?? '');

			if (isset($parts[0]) && ($parts[0] != '')) $this->entity = $parts[0];
			if (isset($parts[1]) && ($parts[1] != '')) $this->action = $parts[1];
		}

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

				$type = '*';
				preg_match('/:\[(get|post|put|delete|patch|\*)]/', $customer, $matches);
				if ($matches) {
					$type = $matches[1];
					$customer = str_replace($matches[0], '', $customer);
				}
				if (!in_array($type, ['*', request()->method()])) continue;

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
				$method = $parts[1] ?? '';

				app()->controllers->run($source, $controller, $method, $params);
			}
		}

	}