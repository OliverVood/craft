<?php

	declare(strict_types=1);

	namespace Base;

	use base\data\set\Input;
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
			$any_any = '*::*';
			$ins_any = $this->entity . '::*';
			$ins_ins = $this->entity . '::' . $this->action;

			foreach ($this->stack as $item) {
				$customer = $item['customer'];
				$performer = $item['performer'];
				$source = $item['source'];

				if ($customer != $any_any && $customer != $ins_any && $customer != $ins_ins) continue;

				$parts = explode('::', $performer);
				$controller = $parts[0];
				$method = $parts[1] ?? '';

				app()->controllers->run($source, $controller, $method);
			}
		}

//		/**
//		 * Возвращает данные от предыдущего запроса
//		 * @param string|null $key - Ключ
//		 * @return Old
//		 */
//		public static function getOld(?string $key = null): Old {
//			return self::$input->old($key);
//		}

	}